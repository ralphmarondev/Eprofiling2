CREATE DATABASE IF NOT EXISTS eprofiling_system;
USE eprofiling_system;

-- =====================================================
-- ROLES
-- =====================================================
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- FAMILIES
-- =====================================================
CREATE TABLE families (
    id INT AUTO_INCREMENT PRIMARY KEY,
    family_code VARCHAR(30) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    household_number VARCHAR(50),
    household_type ENUM(
        'nuclear',
        'extended',
        'single_parent',
        'childless'
    ) NOT NULL,
    housing_ownership ENUM(
        'owned',
        'rented',
        'shared',
        'government',
        'informal_settler'
    ) NOT NULL,
    contact_number VARCHAR(20),
    address TEXT NOT NULL,
    status ENUM(
        'active',
        'inactive'
    ) NOT NULL DEFAULT 'active',
    registration_status ENUM(
        'pending',
        'approved',
        'rejected'
    ) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- MEMBERS
-- =====================================================
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    family_id INT NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    last_name VARCHAR(100) NOT NULL,
    suffix VARCHAR(20),
    sex ENUM(
        'male',
        'female'
    ) NOT NULL,
    date_of_birth DATE NOT NULL,
    place_of_birth VARCHAR(150) NOT NULL,
    civil_status ENUM(
        'single',
        'married',
        'widowed',
        'separated',
        'divorced'
    ) NOT NULL,
    nationality VARCHAR(100) NOT NULL,
    religion VARCHAR(100),
    is_head BOOLEAN NOT NULL DEFAULT FALSE,
    relationship_to_head ENUM(
        'head',
        'spouse',
        'child'
    ) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_members_family
        FOREIGN KEY (family_id)
        REFERENCES families(id)
        ON DELETE CASCADE
);

-- =====================================================
-- ACCOUNTS
-- =====================================================
CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    member_id INT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_accounts_role
        FOREIGN KEY (role_id)
        REFERENCES roles(id),
    CONSTRAINT fk_accounts_member
        FOREIGN KEY (member_id)
        REFERENCES members(id)
        ON DELETE CASCADE
);

-- =====================================================
-- DEFAULT ROLES
-- =====================================================
INSERT INTO roles (name) VALUES
('administrator'),
('staff'),
('family_admin'),
('resident');