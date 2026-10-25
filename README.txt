BREW EUA'S BREW & BITES — LOCAL KIOSK PACKAGE

1. Make a backup of your current folder before replacing anything.
2. Extract this ZIP into C:\laragon\www\brew-euas-kiosk-template (merge/replace the included files).
3. Keep your existing database as-is. Do NOT import the SQL backup into the live database unless you intentionally want to restore it; it is included as a backup.
4. Start Laragon and ensure Apache and MySQL are running.
5. Open http://localhost/brew-euas-kiosk-template/index.php

Included pages:
- index.php: branded home page
- menu.php: products/categories loaded from MySQL, sizes from product_variants, browser cart
- order.php: server-validated checkout saving orders and order_items to MySQL
- staff.php: view orders and update order status
- admin.php: basic product price/availability management and summary
- kiosk.css: branded responsive layout
- logo.jpg: your supplied logo
- assets_hero.png: generated visual used as hero background
- brew_euas_kiosk_complete.sql: backup export

IMPORTANT NOTES:
- Existing db.php uses localhost/root with a blank password; this matches your current Laragon setup.
- Staff and Admin pages do not have login protection yet. They are for local class/demo use only; do not publish to the internet as-is.
- Selecting GCash/Card records the method only; it does not process payment.
- Inventory quantities in the provided database backup are zero. Update stock counts before relying on inventory reporting.
- Product imagery uses emoji-style category illustrations in cards; the generated hero image provides branded visual direction. You can later add individual AI product photos in a separate pass.
- The included SQL is a backup only; do not import over your current database unnecessarily.
