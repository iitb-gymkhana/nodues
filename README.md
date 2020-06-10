# No Dues

Secure portal to track dues in a Symfony-like stack.

## Migrations
Perform migrations with PHP CLI
```bash
vendor/bin/doctrine orm:schema-tool:update --force --dump-sql
```

## Proxy cache generation
Use the following command to generate proxy cache
```
vendor/bin/doctrine orm:generate-proxies
```
