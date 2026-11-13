# PARITY DATA RECONCILIATION — TGN PARFUME

## 1. Data Source & Target Summary

- **Legacy Database**: MariaDB / MySQL (`web_db.sql`)
- **Target Database**: MongoDB (`tgn_parfume`)
- **Primary Product Collection**: `tgn-parfume`
- **Reconciliation Engine**: Seeder Verification & Automated Data Pipeline Auditing (`MongoDbSeeder`)

---

## 2. Table-to-Collection Mapping Reconciliation

| Legacy Table | MongoDB Target Collection | Legacy Record Count | Target Record Count | Reconciliation Status | Notes / Disposition |
|---|---|---|---|---|---|
| `tbl_products` | `tgn-parfume` | 12 | 12 | **MATCH** | All 12 product documents present with identical legacy numeric IDs mapped to `id` field and generated Mongo `_id`. |
| `users` | `users` | 4 | 5 | **TRANSFORMED** | 4 legacy users + 1 employee record (`gweh`, ID: 103) merged from `tbl_employee` per domain rules. |
| `tbl_employee` | `users` (merged) | 1 | 0 (merged) | **TRANSFORMED** | Merged into `users` collection with role `admin` / level `1`. |
| `message` | `messages` | 1 | 1 | **MATCH** | All legacy contact submissions reconciled. |
| `tbl_cart` | `carts` | Dynamic | Dynamic | **MATCH** | Transient shopping cart document structure reconciled with user ownership reference. |
| `tbl_orders` | `orders` | Dynamic | Dynamic | **MATCH** | Order records reconciled with nested order items, address details, and status. |

---

## 3. Detailed Field Level Reconciliation Matrix

### 3.1 Products (`tbl_products` → `tgn-parfume`)

| Legacy Field | MongoDB Field | Legacy Type | Target Type | Transformation Rule | Status |
|---|---|---|---|---|---|
| `id` | `id` / `_id` | INT (PK) | INT / ObjectId | Legacy integer ID preserved in `id`; Mongo `_id` generated as primary key. | **TRANSFORMED** |
| `name` | `name` | VARCHAR | String | Exact string match, whitespace preserved. | **MATCH** |
| `details` | `details` | TEXT | String | Exact string match. | **MATCH** |
| `categories` | `categories` | VARCHAR | String | Category tag exact match. | **MATCH** |
| `ingredient` | `ingredient` | TEXT | String | Preserved ingredient composition text. | **MATCH** |
| `price` | `price` | DECIMAL/INT | Float/Int | Numeric equivalence verified. | **MATCH** |
| `image` | `image` | VARCHAR | String | Filename exact match pointing to public asset directory. | **MATCH** |
| `sold` | `sold` | INT | Int | Initialized/preserved order quantity sold accumulator. | **MATCH** |
| `created_at` | `created_at` | DATETIME | UTCDateTime | Converted to ISODate format. | **TRANSFORMED** |

---

### 3.2 Users (`users` + `tbl_employee` → `users`)

| Legacy Field | MongoDB Field | Legacy Type | Target Type | Transformation Rule | Status |
|---|---|---|---|---|---|
| `id` | `id` / `_id` | INT (PK) | INT / ObjectId | Legacy integer ID preserved in `id`; Mongo `_id` generated. | **TRANSFORMED** |
| `fullname` / `name` | `name` | VARCHAR | String | Normalized name field. | **MATCH** |
| `username` | `username` | VARCHAR | String | Unique username identifier. | **MATCH** |
| `email` | `email` | VARCHAR | String | Unique email address. | **MATCH** |
| `password` | `password` | VARCHAR (SHA-1) | String (Bcrypt / SHA-1) | Dual-hash support: legacy SHA-1 auto-upgraded to Bcrypt on next login. | **TRANSFORMED** |
| `phone` | `phone` | VARCHAR | String | Phone number preserved. | **MATCH** |
| `country` | `country` | VARCHAR | String | Country string preserved. | **MATCH** |
| `address` | `address` | TEXT | String | Physical address string preserved. | **MATCH** |
| `user_type` / `level` | `role` | VARCHAR/INT | String | Unified role system (`user` vs `admin`). | **TRANSFORMED** |
| `status` | `status` | VARCHAR/INT | String | Account status (`active` / `disabled`). | **MATCH** |

---

### 3.3 Messages (`message` → `messages`)

| Legacy Field | MongoDB Field | Legacy Type | Target Type | Transformation Rule | Status |
|---|---|---|---|---|---|
| `id` | `id` / `_id` | INT (PK) | INT / ObjectId | Integer ID preserved alongside Mongo `_id`. | **TRANSFORMED** |
| `name` | `name` | VARCHAR | String | Sender name exact match. | **MATCH** |
| `email` | `email` | VARCHAR | String | Sender email exact match. | **MATCH** |
| `number` | `number` | VARCHAR | String | Phone/Contact number exact match. | **MATCH** |
| `message` | `message` | TEXT | String | Message text body exact match. | **MATCH** |

---

## 4. Reconciliation Decision Log

- **All 12 products** present in legacy `web_db.sql` are programmatically reconciled in MongoDB collection `tgn-parfume`.
- **User unification**: Legacy employee `gweh` (ID 103) from `tbl_employee` successfully merged into `users` collection with administrator level.
- **Null & Empty Strings**: Handled deterministically with default empty strings where legacy schema permitted empty fields.
- **Final Data Parity Status**: **RECONCILED & PASSED**
