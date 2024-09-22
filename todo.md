# Todo

[+] session  
[-] update app to php-server v1.3.0

## Session

- class

```php
    public function getUserId(): int
    {
        return $_SESSION[SessionInterface::SESSION_USER_ID_FIELD] ?? 0;
    }

    public function setUserId(int $id): void
    {
        $_SESSION[SessionInterface::SESSION_USER_ID_FIELD] = $id;
    }
```

- interface

```php
    const SESSION_USER_ID_FIELD = 'user_id';

    /**
     * Get user id if it was provided
     * @return int [0 if there isn't user id]
     */
    public function getUserId(): int;

        /**
     * Set User Id
     */
    public function setUserId(int $id): void;
```