CREATE TABLE wishlist_items (
    id BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    wishlist_id BIGINT NOT NULL,
    added_by BIGINT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    url VARCHAR(500),
    image_url VARCHAR(500),
    estimated_price DECIMAL(10,2),
    priority TINYINT UNSIGNED NOT NULL,
    status VARCHAR(100) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_wl_wishlist FOREIGN KEY (wishlist_id) REFERENCES wishlists(id)
    ON DELETE CASCADE,
    CONSTRAINT fk_ab_added_by FOREIGN KEY (added_by) REFERENCES users(id)
);