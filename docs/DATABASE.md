# Database

## Database

```sql
CREATE DATABASE IF NOT EXISTS eprofiling_system;
USE eprofiling_system;
```

---

## Role

```sql
CREATE TABLE role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);
```

---

## Family

```sql
CREATE TABLE family (
    id INT AUTO_INCREMENT PRIMARY KEY,
    family_code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    processed_by INT NULL
);
```

---

## Members

```sql
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    suffix VARCHAR(20),
    age INT NOT NULL,
    family_id INT NOT NULL,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    processed_by INT NULL,

    FOREIGN KEY (family_id)
        REFERENCES family(id)
);
```

---

## Accounts

Accounts serve as the main authentication entity. An account may exist without being associated with a member or family.

Examples:

* Administrator accounts
* Staff accounts
* System accounts

Accounts that represent family members may optionally be linked to a member profile.

```sql
CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    member_id INT NULL,
    role_id INT NOT NULL,
    is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (member_id)
        REFERENCES members(id),

    FOREIGN KEY (role_id)
        REFERENCES role(id)
);
```

---

## Relationship

Stores relationship information between members within a family.

```sql
CREATE TABLE relationship (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    related_member_id INT NOT NULL,
    relationship_type VARCHAR(50) NOT NULL,

    FOREIGN KEY (member_id)
        REFERENCES members(id),

    FOREIGN KEY (related_member_id)
        REFERENCES members(id)
);
```

---

## Default Roles

```sql
INSERT INTO role (name)
VALUES
('Administrator'),
('Staff'),
('FamilyAdmin'),
('User');
```
