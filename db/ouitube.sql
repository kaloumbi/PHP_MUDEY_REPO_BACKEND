CREATE DATABASE OUITUBE;

CREATE TABLE OUITUBE.USERS(
    _id VARCHAR(60) PRIMARY KEY,
    full_name VARCHAR(60),
    email VARCHAR(60),
    description TEXT,
    password VARCHAR(255),
    created_at DateTime,
    updated_at DateTime
);
CREATE TABLE OUITUBE.VIDEOS(
    _id VARCHAR(60) PRIMARY KEY,
    name VARCHAR(60),
    slug VARCHAR(255) UNIQUE,
    description TEXT,
    duration VARCHAR(10),
    categoryId VARCHAR(60), --FOREIGN KEY
    userId VARCHAR(60), --FOREIGN KEY
    imageUrl VARCHAR(255),
    videoUrl VARCHAR(255),
    views INT,
    created_at DateTime,
    updated_at DateTime
    CONSTRAINT FOREIGN KEY (userId) REFERENCES USERS(_id),
    CONSTRAINT FOREIGN KEY (categoryId) REFERENCES USERS(_id),
);
CREATE TABLE OUITUBE.CATEGORY(
    _id VARCHAR(60) PRIMARY KEY,
    name VARCHAR(60),
    description TEXT,
    imageUrl VARCHAR(255),
    created_at DateTime,
    updated_at DateTime
);
CREATE TABLE OUITUBE.COMMENT(
    _id VARCHAR(60) PRIMARY KEY,
    userId VARCHAR(60), -- FOREIGN KEY
    videoId VARCHAR(60), -- FOREIGN KEY
    content TEXT,
    created_at DateTime,
    updated_at DateTime,
    CONSTRAINT FOREIGN KEY (userId) REFERENCES USERS(_id),
    CONSTRAINT FOREIGN KEY (videoId) REFERENCES VIDEOS(_id)
);
CREATE TABLE OUITUBE.REVIEWS(
    _id VARCHAR(60) PRIMARY KEY,
    userId VARCHAR(60), --FOREIGN KEY
    videoId VARCHAR(60), --FOREIGN KEY
    content VARCHAR(60),
    created_at DateTime,
    updated_at DateTime,
    CONSTRAINT FOREIGN KEY (userId) REFERENCES USERS(_id),
    CONSTRAINT FOREIGN KEY (videoId) REFERENCES VIDEOS(_id)
);
