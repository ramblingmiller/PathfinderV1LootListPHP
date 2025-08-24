<?php

/**
 * Treasure Model
 *
 * Encapsulates all database operations related to treasure items.
 * This includes adding new items, updating their status (sold/broken),
 * and fetching treasure for a specific player.
 */
class Treasure
{
    /**
     * @var mysqli The database connection object.
     */
    private $db_con;

    /**
     * Constructor for the Treasure model.
     *
     * @param mysqli $db_con A mysqli database connection object.
     */
    public function __construct(mysqli $db_con)
    {
        $this->db_con = $db_con;
    }

    /**
     * Retrieves all non-sold and non-broken treasure for a given player.
     *
     * @param string $playerName The name of the player.
     * @return array An array of treasure items.
     */
    public function getByPlayerName(string $playerName): array
    {
        $stmt = $this->db_con->prepare("SELECT * FROM `Treasure` WHERE `playerName` = ? AND `sold` = 0 AND `broken` = 0 ORDER BY `id` DESC");
        $stmt->bind_param("s", $playerName);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Adds a new treasure item to the database.
     *
     * @param int $qty The quantity of the item.
     * @param string $itemName The name of the item.
     * @param float $value The value of the item.
     * @param string $playerName The name of the player who owns the item.
     * @return bool True on success, false on failure.
     */
    public function add(int $qty, string $itemName, float $value, string $playerName): bool
    {
        $stmt = $this->db_con->prepare("INSERT INTO `Treasure` (`qty`, `itemName`, `value`, `playerName`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isds", $qty, $itemName, $value, $playerName);
        return $stmt->execute();
    }

    public function updateStatus(int $id, bool $sold, bool $broken): bool
    {
        // Booleans are bound as integers (0 or 1)
        $stmt = $this->db_con->prepare("UPDATE `Treasure` SET `sold` = ?, `broken` = ? WHERE `id` = ?");
        $stmt->bind_param("iii", $sold, $broken, $id);
        return $stmt->execute();
    }
}

