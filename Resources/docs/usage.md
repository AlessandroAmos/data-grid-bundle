
# Usage

The component provides two base abstractions - **Grid Factory** and **Grid Schema**.

## Grid Schema

Think of the Schema as a set of rules for how to get data based on what the user asks for.

**Here is a simple example of a grid schema:**

```php
use Spiral\DataGrid\GridSchema; 
use Spiral\DataGrid\Specification\Filter\Like;
use Spiral\DataGrid\Specification\Pagination\PagePaginator;
use Spiral\DataGrid\Specification\Sorter\Sorter;
use Spiral\DataGrid\Specification\Value\StringValue;

$schema = new GridSchema();

// User pagination: limit results to 10 per page
$schema->setPaginator(new PagePaginator(10));

// Sorting option: by id
$schema->addSorter('id', new Sorter('id'));

// Filter option: find by name matching user input
$schema->addFilter('name', new Like('name', new StringValue()));
```

In short, with Schema, developers can customize filters and sorting options when fetching data.

For a cleaner setup, you can extend the `GridSchema` and set everything inside its constructor, like in the example
below:

```php
use Spiral\DataGrid\GridSchema; 
use Spiral\DataGrid\Specification\Pagination\PagePaginator;
use Spiral\DataGrid\Specification\Sorter\Sorter;
use Spiral\DataGrid\Specification\Filter\Like;
use Spiral\DataGrid\Specification\Value\StringValue;

class UserSchema extends GridSchema
{
    public function __construct()
    {
        // User pagination: limit results to 10 per page
        $this->setPaginator(new PagePaginator(10));
        
        // Sorting option: by id
        $this->addSorter('id', new Sorter('id'));
        
        // Filter option: find by name matching user input
        $this->addFilter('name', new Like('name', new StringValue()));
    }
}
```

### Grid Factory

Grid Factory is the link between your grid schema and the actual data you want to retrieve. The following code example
demonstrates how to connect the schema to data using the Cycle ORM Repository:

```php
use Spiral\DataGrid\GridSchema;
use Spiral\DataGrid\GridFactoryInterface;

$schema = new UserSchema();

$factory = $container->get(GridFactoryInterface::class);
$users = $container->get(\App\Database\UserRepository::class);
  
/** @var Spiral\DataGrid\GridInterface $result */
$result = $factory->create($users->select(), $schema);  

// Fetch the refined data
print_r(iterator_to_array($result));  
```

You can also set default specifications:

```php
/** @var Spiral\DataGrid\GridFactory $factory */
$factory = $factory->withDefaults([
    GridFactory::KEY_SORT     => ['id' => 'desc'],
    GridFactory::KEY_FILTER   => ['name' => 'Antony'],
    GridFactory::KEY_PAGINATE => ['page' => 3, 'limit' => 100]
]);
```

> **Note**
> Because the `withDefaults` method is immutable, calling it doesn't alter the original Grid Factory. Instead, it gives
> you a new instance with the specified defaults.

How to apply the specifications:

- to select users from the second page open page with `POST` or `QUERY` data like: `?paginate[page]=2`
- to activate the `like` filter: `?filter[name]=antony`
- to sort by id in `ASC` or `DESC`: `?sort[id]=desc`
- to get count of total values: `?fetchCount=1`

Finally, the last code example shows what a sample controller might look like when putting everything together:

```php

use Spiral\DataGrid\GridInterface;
use Spiral\DataGrid\GridFactoryInterface;
use App\Database\UserRepository;
use Spiral\DataGrid\GridSchema;
use Spiral\DataGrid\Specification\Value;
use Spiral\DataGrid\Specification\Filter;

class UserController
{
    #[Route(...)]
    public function index(GridFactoryInterface $factory, UserRepository $users): array
    {
        $schema = new GridSchema();
        $schema->addFilter('name', new Filter\Like('name', new Value\StringValue()));
        $schema->addFilter('active', new Filter\Equals('active', new Value\BoolValue()));
       
        // result will be iterable of User objects 
        $result = $factory->create($users->select(), $schema);
       
       return new JsonResponse(
            array_map(
                fn($user) => $user->getName(), 
                iterator_to_array($result)
            )
       );
    }
}
```

