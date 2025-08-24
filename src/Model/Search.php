<?php

/**
 * Search Model
 *
 * Encapsulates database operations for searching across different tables.
 */
class Search
{
    /**
     * @var mysqli The database connection object.
     */
    private $db_con;

    /**
     * Constructor for the Search model.
     *
     * @param mysqli $db_con A mysqli database connection object.
     */
    public function __construct(mysqli $db_con)
    {
        $this->db_con = $db_con;
    }

    /**
     * Searches for equipment by name.
     *
     * @param string $term The search term.
     * @return array An array of matching equipment items.
     */
    public function searchEquipment(string $term): array
    {
        $searchTerm = $term . '%';
        $stmt = $this->db_con->prepare(
            "SELECT `itemName`, `value` FROM `Equipment` WHERE `itemName` LIKE ? ORDER BY `itemName` ASC LIMIT 10"
        );
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

