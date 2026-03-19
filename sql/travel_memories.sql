CREATE TABLE IF NOT EXISTS travel_memories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    location VARCHAR(255),
    event_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS memory_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    memory_id INT,
    image_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (memory_id) REFERENCES travel_memories(id) ON DELETE CASCADE
);
