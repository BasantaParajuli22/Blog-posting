#SQl for creating table
### Register table
```
CREATE TABLE reg_table(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    email VARCHAR(50),
    password VARCHAR(50)
);
```

### comment table
```
CREATE TABLE comment_table(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    content VARCHAR(100)
    comment_to VARCHAR(50)
);
```
### post table
```
CREATE TABLE post_table(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50),
    content VARCHAR(100)
    username VARCHAR(100)
);
```