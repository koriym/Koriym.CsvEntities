# Koriym.CsvEntities

[Japanese](README.ja.md)

## PDO - Fetching one to many related tables together


Create a one-to-many entity list with Todo having multiple Memos in PDO as shown below.

### Example

```sql
SELECT todo.id AS id,
       todo.title AS title,
       memo.id AS memo_id,
       memo.body AS memo_body
FROM todo
       LEFT OUTER JOIN memo
       ON memo.todo_id = todo.id
GROUP BY todo.id;
```

Memo class
```php
final class Memo
{
    public string $id,
    public string $title
}
````

Todo class
````php
final class Todo
{
    public string $id,
    public string $title,
    /** @var array<Memo> */
    public array $memos,
}
````

## Usage

Change the above SQL and entity classes as follows.

```sql
SELECT todo.id AS id,
       todo.title AS title,
       GROUP_CONCAT(memo.id),
       GROUP_CONCAT(memo.body)
FROM todo
       LEFT OUTER JOIN memo
       ON memo.todo_id = todo.id
GROUP BY todo.id;
```

```php
final class Memo
{
    public function __construct(
        public string $id,
        public string $title
    ){}
}
```

```php
final class Todo
{
    /** @var array<Memo> */
    public array $memos;

    public function __construct(
        public string $id,
        public string $title,
        string|null $memoIds,
        string|null $memoBodies
    ){
        $this->memos = (new CsvEntities())(Memo::class, $memoIds, $memoBodies);
    }
}
```

After `query()` SQL, fetchAll as follows.

```php
$todoList = $pdo->fetchAll(PDO::FETCH_FUNC, static function (...$args) {
    return new Todo(...$args);
});
```

We get the `Todo[]` array we originally intended.

```php
final class Todo
{
    public string $id,
    public string $title,
    /** @var array<Memo> */
    public array $memos,
}
```

Separator can be specified。

```php
$this->memos = (new CsvEntities())->get("\t", Memo::class, $memoIds, $memoBodies); // tab separator
```

## Set maximum concatenation value for GROUP_CONCAT

The maximum value of the concatenation process of columns using `GROUP_CONCAT` must be changed to `group_concat_max_len` in an ini file or query. (default value is 1024)

```sql
SET SESSION group_concat_max_len = 200000;
```

## Install

```
composer require koriym/csv-entities
```
