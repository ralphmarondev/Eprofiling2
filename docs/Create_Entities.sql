CREATE DATABASE IF NOT EXISTS eprofiling_system;
USE eprofiling_system;

-- =====================================================
-- ROLES
-- =====================================================
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    create_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
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
    create_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
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
    occupation VARCHAR(150),
    educational_attainment VARCHAR(100),
    is_head BOOLEAN NOT NULL DEFAULT FALSE,
    relationship_to_head ENUM(
        'head',
        'spouse',
        'child'
    ) NOT NULL,
    is_voter BOOLEAN NOT NULL DEFAULT FALSE,
    is_indigenous BOOLEAN NOT NULL DEFAULT FALSE,
    indigenous_group VARCHAR(100),

    create_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_members_family
        FOREIGN KEY (family_id)
        REFERENCES families(id)
        ON DELETE CASCADE
);

-- =====================================================
-- BENEFICIARY PROGRAMS
-- =====================================================
CREATE TABLE beneficiary_programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    create_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- MEMBER BENEFICIARY PROGRAMS
-- =====================================================
CREATE TABLE member_beneficiaries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    program_id INT NOT NULL,
    create_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT uq_member_program
        UNIQUE (member_id, program_id),

    CONSTRAINT fk_mbp_member
        FOREIGN KEY (member_id)
        REFERENCES members(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_mbp_program
        FOREIGN KEY (program_id)
        REFERENCES beneficiary_programs(id)
        ON DELETE CASCADE
);

INSERT INTO beneficiary_programs (name, description) VALUES
('4Ps', 'Pantawid Pamilyang Pilipino Program'),
('Senior Citizen Pension', 'Social Pension for Indigent Senior Citizens'),
('Solo Parent', 'Solo Parent Assistance Program'),
('PWD', 'Persons with Disability Assistance'),
('PhilHealth', 'PhilHealth Membership'),
('Educational Assistance', 'Educational Financial Assistance'),
('Medical Assistance', 'Medical Financial Assistance'),
('Livelihood Program', 'Livelihood Assistance'),
('Rice Assistance', 'Rice Distribution Program'),
('Cash Assistance', 'Emergency Cash Assistance'),
('Scholarship', 'Government Scholarship Program'),
('Farmer Assistance', 'Programs for Farmers'),
('Fisherfolk Assistance', 'Programs for Fisherfolk'),
('OFW', 'Overseas Filipino Workers');

-- =====================================================
-- ACCOUNTS
-- =====================================================
CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    member_id INT UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
    create_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    update_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_accounts_role
        FOREIGN KEY (role_id)
        REFERENCES roles(id),
    CONSTRAINT fk_accounts_member
        FOREIGN KEY (member_id)
        REFERENCES members(id)
        ON DELETE SET NULL
);

-- =====================================================
-- DEFAULT ROLES
-- =====================================================
INSERT INTO roles (name) VALUES
('administrator'),
('staff'),
('family_admin'),
('resident');