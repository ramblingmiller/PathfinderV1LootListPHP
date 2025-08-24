<?php

/**
 * Coin Model
 *
 * Encapsulates all database operations related to player coins.
 */
class Coin
{
    /**
     * @var mysqli The database connection object.
     */
    private $db_con;

    /**
     * Constructor for the Coin model.
     *
     * @param mysqli $db_con A mysqli database connection object.
     */
    public function __construct(mysqli $db_con)
    {
        $this->db_con = $db_con;
    }

    /**
     * Retrieves the current gold amount for a given player.
     *
     * @param string $playerName The name of the player.
     * @return float The player's gold amount, or 0.0 if not found.
     */
    public function getGold(string $playerName): float
    {
        $stmt = $this->db_con->prepare("SELECT `gold` FROM `Coins` WHERE `playerName` = ?");
        $stmt->bind_param("s", $playerName);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row ? (float)$row['gold'] : 0.0;
    }

    /**
     * Adds a specified amount of gold to a player's total.
     *
     * @param string $playerName The name of the player.
     * @param float $amount The amount of gold to add.
     * @return bool True on success, false on failure.
     */
    public function addGold(string $playerName, float $amount): bool
    {
        $stmt = $this->db_con->prepare("UPDATE `Coins` SET `gold` = `gold` + ? WHERE `playerName` = ?");
        $stmt->bind_param("ds", $amount, $playerName);
        return $stmt->execute();
    }
}

