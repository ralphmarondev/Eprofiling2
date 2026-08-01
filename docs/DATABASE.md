## Database Schema

### Database Setup
```sql
CREATE DATABASE IF NOT EXISTS eprofiling_system;
USE eprofiling_system;
```

### Tables

#### 1. Role
Stores user roles for access control.

```sql
CREATE TABLE role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Default Roles:**
- Administrator (1)
- Staff (2)
- FamilyAdmin (3)
- User (4)

---

#### 2. Family
Stores family profile information.

```sql
CREATE TABLE family (
    id INT AUTO_INCREMENT PRIMARY KEY,
    family_code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    household_number VARCHAR(50) NULL,
    household_type ENUM('nuclear', 'extended', 'single_parent') NULL,
    housing_ownership ENUM('owned', 'rented', 'informal_settler') NULL,
    contact_number VARCHAR(20) NULL,
    address TEXT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    registration_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    head_of_family_id INT NULL,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    processed_by INT NULL
);
```

**Field Descriptions:**
- `family_code`: Unique identifier (auto-generated from family name)
- `household_number`: Optional barangay numbering system
- `household_type`: Nuclear, Extended, or Single Parent
- `housing_ownership`: Owned, Rented, or Informal Settler
- `registration_status`: Tracks approval workflow
- `head_of_family_id`: References the head member (foreign key)

---

#### 3. Members
Stores individual member information within a family.

```sql
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    family_id INT NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100) NULL,
    last_name VARCHAR(100) NOT NULL,
    suffix VARCHAR(20) NULL,
    sex ENUM('male', 'female') NOT NULL,
    date_of_birth DATE NOT NULL,
    place_of_birth VARCHAR(255) NOT NULL,
    civil_status ENUM('single', 'married', 'widowed', 'separated', 'divorced') NOT NULL,
    nationality VARCHAR(100) NOT NULL,
    religion VARCHAR(100) NULL,
    is_head BOOLEAN DEFAULT FALSE,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    processed_by INT NULL,
    
    FOREIGN KEY (family_id) 
        REFERENCES family(id) 
        ON DELETE CASCADE
);
```

**Field Descriptions:**
- `is_head`: Boolean flag identifying the head of family
- `date_of_birth`: Used for age calculation (more accurate than storing age)
- `place_of_birth`: City/Municipality, Province format
- `civil_status`: Single, Married, Widowed, Separated, Divorced

---

#### 4. Accounts
Main authentication entity. Accounts may exist without being associated with a member (e.g., admin accounts).

```sql
CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    member_id INT NULL,
    role_id INT NOT NULL,
    is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (member_id) 
        REFERENCES members(id) 
        ON DELETE SET NULL,
    
    FOREIGN KEY (role_id) 
        REFERENCES role(id)
);
```

**Features:**
- Email is optional (can be NULL)
- Member association is optional
- Soft delete support via `is_deleted` flag
- Role-based permissions

---

#### 5. Relationship
Stores relationship information between members within a family.

```sql
CREATE TABLE relationship (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    related_member_id INT NOT NULL,
    relationship_type VARCHAR(50) NOT NULL,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (member_id) 
        REFERENCES members(id) 
        ON DELETE CASCADE,
    
    FOREIGN KEY (related_member_id) 
        REFERENCES members(id) 
        ON DELETE CASCADE
);
```

---

### Foreign Key Constraints

```sql
-- Family head reference
ALTER TABLE family 
ADD CONSTRAINT fk_family_head 
FOREIGN KEY (head_of_family_id) 
REFERENCES members(id) 
ON DELETE SET NULL;
```

---

## Registration Flow

### Frontend Steps
1. **Step 1: Family Information**
   - Family Code (auto-generated)
   - Family Name
   - Household Number (optional)
   - Household Type (optional)
   - Housing Ownership (optional)
   - Contact Number (optional)

2. **Step 2: Address Details**
   - House No./Street
   - Barangay
   - Municipality/City
   - Province

3. **Step 3: Head of Family Details**
   - First Name, Middle Name (optional), Last Name
   - Suffix (optional)
   - Sex, Date of Birth, Place of Birth
   - Civil Status
   - Nationality
   - Religion (optional)

4. **Step 4: Account Creation**
   - Username (required)
   - Email (optional)
   - Password (min 6 characters)

### Backend API Endpoint

#### `api/admin_family_create.php`

**Method:** POST  
**Description:** Creates a new family with head member and account in a single transaction.

**Request Parameters:**
- Family Information: `family_name`, `family_code`, `household_number`, `household_type`, `housing_ownership`, `contact_number`
- Address: `house_no`, `barangay`, `municipality`, `province`
- Member: `first_name`, `middle_name`, `last_name`, `suffix`, `sex`, `date_of_birth`, `place_of_birth`, `civil_status`, `nationality`, `religion`
- Account: `username`, `email`, `password`

**Response:**
```json
{
    "success": true,
    "message": "Family registered successfully!",
    "data": {
        "family_id": 1,
        "family_code": "FAM-SANTOS",
        "family_name": "Santos Family",
        "member_id": 1,
        "member_name": "Juan Santos",
        "account_id": 1,
        "username": "juansantos"
    }
}
```

**Error Response:**
```json
{
    "success": false,
    "message": "Error description here"
}
```

**Features:**
- Transaction-based (all or nothing)
- Duplicate checks for family_code, username, email
- Password hashing
- Registration status set to 'approved' (admin action)
- Returns all generated IDs

---

## API Endpoints

### Family Management
- `api/admin_family_create.php` - Create new family with member and account
- `api/family_create.php` - Create family only (deprecated - use admin version)
- `api/family_list.php` - List all families
- `api/family_view.php` - View specific family details

### Member Management
- `api/member_create.php` - Create member (deprecated - use admin version)
- `api/member_list.php` - List family members
- `api/member_view.php` - View specific member

### Account Management
- `api/account_register.php` - Register account (deprecated - use admin version)
- `api/account_login.php` - User login
- `api/account_profile.php` - Get user profile

---

## Development Notes

### Family Code Generation
- Format: `FAM-{FAMILY_NAME}`
- Example: `FAM-SANTOS` for "Santos Family"
- Auto-generated from family name input
- Removes spaces and special characters
- Converts to uppercase

### Password Requirements
- Minimum 6 characters
- Hashed using `password_hash()` with PASSWORD_DEFAULT

### Registration Status Flow
1. Admin creates family → `approved` (immediate)
2. User self-registers → `pending` (requires admin approval)
3. Admin can approve/reject pending registrations

### Soft Delete
- Accounts support soft delete via `is_deleted` flag
- Keeps historical data while preventing login
- Can be restored if needed

### Cascading Rules
- Deleting a family → Deletes all members (CASCADE)
- Deleting a member → Sets account member_id to NULL (SET NULL)
- Deleting a family → Removes head_of_family_id reference (SET NULL)

---

## Installation Steps

1. Import the database schema using the provided SQL scripts
2. Update `config/database.php` with your database credentials
3. Ensure PHP MySQL extension is enabled
4. Configure web server to point to the project root

## Future Enhancements

- [ ] Member relationship management
- [ ] Family history/audit log
- [ ] Approval workflow notifications
- [ ] Bulk family import
- [ ] Export reports
- [ ] Family tree visualization
- [ ] Mobile app integration

---

## Database Diagram

```
role (id, name)
  ↓
accounts (id, username, email, password, member_id, role_id)
  ↓
members (id, family_id, first_name, last_name, ...)
  ↓
family (id, family_code, name, ...)
  ↓
relationship (id, member_id, related_member_id, relationship_type)
```

---

## Migration Notes

### From Previous Schema
- `age` column removed, replaced with `date_of_birth`
- `email` in accounts is now optional (NULL allowed)
- Added `household_number`, `household_type`, `housing_ownership` to family
- Added `sex`, `place_of_birth`, `civil_status`, `nationality`, `religion` to members
- Added `registration_status` to family for approval workflow
- Added `is_head` flag to members
- Added `head_of_family_id` foreign key to family

### Rollback Instructions
If you need to revert to the previous schema:
```sql
-- Backup data first!
-- Then drop the new columns and recreate old structure
-- Refer to previous migration scripts
```

---

## Troubleshooting

### Common Issues

**"Family code already exists"**
- Family codes must be unique
- Check if the code already exists in the family table

**"Username already exists"**
- Usernames must be unique in accounts table
- Try a different username

**"Password must be at least 6 characters"**
- Password length validation occurs on the server
- Ensure passwords meet minimum length requirement

**"Email already exists"**
- Email must be unique if provided
- Leave email blank if you don't want to use it

**Foreign key constraint fails**
- Check if referenced family/member exists
- Ensure correct order of operations in transactions

---

## Support

For issues or questions, contact the development team.
