CREATE TABLE IF NOT EXISTS couple_members (
    id BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    couple_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT uq_couple_user UNIQUE (couple_id, user_id),

    CONSTRAINT fk_cm_couple
    FOREIGN KEY (couple_id) REFERENCES couples(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_cm_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
);

CREATE TRIGGER trg_couple_member_limit
BEFORE INSERT ON couple_members
FOR EACH ROW
BEGIN
    DECLARE member_count INT;
    SELECT COUNT(*) INTO member_count
    FROM couple_members
    WHERE couple_id = NEW.couple_id;

    IF member_count >= 2 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'A couple can have at most 2 members.';
    END IF;
END;
