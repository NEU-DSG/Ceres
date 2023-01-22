<?php 

namespace Ceres\Fetcher;

// TODO: are the requires already added elsewhere?
//require_once ("AbstractFetcher.php");

class Sparql extends AbstractFetcher {

    protected string $queryType = 'SELECT'; // 'SELECT' or 'CONSTRUCT'
    
    protected array $prefixes = [
        'dcterms' => '',
        'dc' => '',

        
    ];

    /**
     * whereQueryClauses
     * 
     * a list of base query clauses, before filter, optional, service, etc
     *
     * @var array
     */

    protected array $whereQueryClauses = [];

    protected array $optionalClauses = [];

    protected array $filterClauses = [];

    protected array $serviceClauses = [];

    protected array $orderByClauses = [];

    protected array $bindings = [];

    protected string $query = "";


    public function __construct() {
    }

    public function addPrefix(string $prefix, string $uri) {
        $this->prefixes[$prefix] = $uri;
    }


    /**
     * addWhereQueryClause
     * 
     * Not necessarily a single line, to allow for multiline ttl bits
     *
     * @param string $clause
     * @return void
     */
    public function addWhereQueryClause(string $clause) {
        $this->whereQueryClauses[] = $clause;
    }

    public function addOptionalClause(string $clause) {
        $this->optionalClauses[] = $clause;
    }

    public function addServiceClause(string $clause) {
        $this->serviceClauses[] = $clause;
    }

    public function addFilterClause(string $clause) {
        $this->filterClauses[] = $clause;
    }

    public function addOrderByClause(string $clause) {
        $this->orderByClauses[] = $clause;
    }

    public function build() {
        $query = "";
        $query .= $this->buildPrefixes();
        $query .= $this->buildQueryBindings(); //select, construct, ask, etc
        $query .= $this->buildWhere();
    }

    protected function buildWhere() {
        $whereQuery = "";
        $whereQuery .= $this->buildWhereClauses();
        $whereQuery .= $this->buildOptionalClauses();
        $whereQuery .= $this->buildFilterClauses();
        $whereQuery .= $this->buildOrderByClauses();
        $whereQuery .= $this->buildServiceClauses();
        return $whereQuery;
    }

    protected function buildPrefixes() {
        $prefixString = "";
        foreach ($this->prefixes as $prefix=>$uri) {
            $prefixString .= "PREFIX $prefix <$uri>;";
        }
        return $prefixString;
    }

    protected function buildQueryBindings() {
        $bindingsString = "{$this->queryType}";
        foreach($this->bindings as $binding) {
            $bindingsString .= "?$binding ";
        }
    }

    protected function buildWhereClauses() {
        $whereClauses = "";
        foreach ($this->whereQueryClauses as $clause) {
            $whereClauses .= "$clause \n";
        }
        return $whereClauses;
    }

    protected function buildOptionalClauses() {
        $optionalClauses = "";
        foreach ($this->optionalClauses as $clause) {
            $optionalClauses .= "OPTIONAL $clause \n";
        }
        return $optionalClauses;
    }

    protected function buildFilterClauses() {
        $filterClauses = "";
        foreach ($this->filterClauses as $clause) {
            $filterClauses .= "\nFILTER $clause \n";
        }
        return $filterClauses;
    }


    protected function buildOrderByClauses() {
        $orderByClauses = "";
        foreach ($this->orderByClauses as $clause) {
            $orderByClauses .= "\nORDER BY $clause \n";
        }
        return $orderByClauses;
    }

    protected function buildServiceClauses() {
        $serviceClauses = "";
        foreach ($this->serviceClauses as $clause) {
            $serviceClauses .= "SERVICE $clause \n";
        }
    }
}
