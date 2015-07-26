CREATE TABLE users (
  user_id             BIGINT(20) AUTO_INCREMENT,
  user_login          VARCHAR(80) UNIQUE,
  user_email          VARCHAR(80) UNIQUE,
  user_password       VARCHAR(128),
  user_registered     DATETIME,
  user_activation_key VARCHAR(128),
  user_status         INT(3),
  PRIMARY KEY (user_id)
)
  ENGINE = InnoDB, CHARSET = 'utf-8';

CREATE TABLE rave_comments (
  comment_id      BIGINT(30) AUTO_INCREMENT,
  comment_title   VARCHAR(150),
  comment_content VARCHAR(500),
  comment_author  BIGINT(20),
  comment_post    DATETIME,
  FOREIGN KEY (comment_author) REFERENCES rave_user (user_id),
  PRIMARY KEY (comment_id)
)
  ENGINE = InnoDB, CHARSET = 'utf-8';