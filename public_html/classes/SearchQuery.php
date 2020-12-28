<?php
class SearchQuery
{
    public $query;
    public $argc;
    public $type;

    function __construct(string $query, int $argc = 0, string $type = "")
    {
        $this->argc = $argc;
        $this->type = $type;
        $this->query = $query;
    }
};

$criteria_query_assoc = [
    'searchtext' => new SearchQuery("name LIKE CONCAT('%',?,'%')", 1, "s"),
    'price-range' => new SearchQuery("price <= ?", 1, "i"),
];
