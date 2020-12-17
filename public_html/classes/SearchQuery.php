<?php
    class SearchQuery{
        public string $query;
        public int $argc;
        public string $type; 

        function __construct(string $query, int $argc=0, string $type=""){
            $this->argc = $argc;
            $this->type = $type;
            $this->query = $query;
        }

    };

    $criteria_query_assoc = [
        'searchtext' => new SearchQuery("name LIKE CONCAT('%',?,'%')", 1, "s" ),
        'from0to10' => new SearchQuery("price BETWEEN 0 AND 10"),
        'from10to20' => new SearchQuery("price BETWEEN 10 AND 20"),
        'over20' => new SearchQuery("price > 20"),

    ];

