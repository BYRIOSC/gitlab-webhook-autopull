# yiban-byr-gitlab-webhook-autopull

A php tiny http server for auto pull with a git remote

# Usage

1. clone this repo.

2. go to the repo's settings page and set "URL" and "Secret Token"

3. edit 'yiban.byr.gitlab.webhook.autopull.php' as follows
```
$exec_pair = [
    "secret-token" 
    =>
    "cd /path/to/the/project && git pull"
];
```

4. exec the following command as daemon

```
php -S listen.to.address:port yiban.byr.gitlab.webhook.autopull.php
```
