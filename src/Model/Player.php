<?php

/**
 * Player Model
 *
 * Encapsulates database operations related to a player,
 * such as adding a new player to the Players and Coins tables.
 */
class Player
{
    /**
     * @var mysqli The database connection object.
     */
    private $db_con;

    /**
     * Constructor for the Player model.
     *
     * @param mysqli $db_con A mysqli database connection object.
     */
    public function __construct($db_con)
    {
        $this->db_con = $db_con;
    }

    

    /**
     * Adds a new player to the database.
     *
     * This method inserts a new record into the `Players` table and
     * initializes their gold in the `Coins` table. It checks to prevent
     * duplicate entries in both tables.
     *
     * @param string $playerName The name of the player.
     * @param string|null $charName The character's name.
     * @param string|null $charClass The character's class.
     * @param string|null $charRace The character's race.
     * @param int|null $charLvl The character's level.
     * @return void
     */
    public function addPlayer($playerName, $charName, $charClass, $charRace, $charLvl)
    {
        // Use prepared statements to prevent SQL injection.

        // 1. Add to Players table if not exists
        $stmt_check_player = $this->db_con->prepare("SELECT 1 FROM `Players` WHERE `playerName` = ?");
        $stmt_check_player->bind_param("s", $playerName);
        $stmt_check_player->execute();
        $result_player = $stmt_check_player->get_result();

        if ($result_player->num_rows === 0) {
            $stmt_insert_player = $this->db_con->prepare(
                "INSERT INTO `Players` (`playerName`, `charName`, `class`, `race`, `level`) VALUES (?, ?, ?, ?, ?)"
            );
            // Bind all params as strings to correctly handle NULL for the integer `level` column.
            // MySQL will cast the types appropriately.
            $stmt_insert_player->bind_param("sssss", $playerName, $charName, $charClass, $charRace, $charLvl);
            
            if (!$stmt_insert_player->execute()) {
                error_log("Error adding player to Players table: " . $stmt_insert_player->error);
            }
            $stmt_insert_player->close();
        }
        $stmt_check_player->close();

        // 2. Add to Coins table if not exists
        $stmt_check_coins = $this->db_con->prepare("SELECT 1 FROM `Coins` WHERE `playerName` = ?");
        $stmt_check_coins->bind_param("s", $playerName);
        $stmt_check_coins->execute();
        $result_coins = $stmt_check_coins->get_result();

        if ($result_coins->num_rows === 0) {
            $stmt_insert_coins = $this->db_con->prepare(
                "INSERT INTO `Coins` (`playerName`, `gold`) VALUES (?, 0.00)"
            );
            $stmt_insert_coins->bind_param("s", $playerName);
            if (!$stmt_insert_coins->execute()) {
                error_log("Error adding player to Coins table: " . $stmt_insert_coins->error);
            }
            $stmt_insert_coins->close();
        }
        $stmt_check_coins->close();
    }
}

