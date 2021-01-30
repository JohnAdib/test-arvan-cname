# test-arvan-cname


## reload nginx config every minute
We need to refresh config files every minute
```sudo nano /etc/crontab```
copy below code and save crontab
```* * * * * service nginx reload```


