<?php

class Database {

    private $mysqli;

    public function __construct(){
        include_once __DIR__.'/../config/database.php';
        $this->mysqli = new mysqli(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME
        );
    }

    public function connect(){

        if ($this->mysqli){
            return $this->mysqli;
        }

    }

    public function getAllResultWithPagination($pageName, $table, $sql, $limit = 10, $linksAfterAndBefore = 5){

        $statCount = $this->mysqli->query("SELECT COUNT(*) as total FROM $table");
        $resultCount = $statCount->fetch_assoc();
        $total = $resultCount['total'];

        $totalPages = ceil($total / $limit);

        $page = isset($_GET['pagno']) && is_numeric($_GET['pagno']) && $_GET['pagno'] <= $totalPages && $_GET['pagno'] > 1 ? abs($_GET['pagno']) : 1;
        $start = ($page - 1) * $limit;

        $stat = $this->mysqli->query("$sql LIMIT $start, $limit");
        $result = $stat->fetch_all(MYSQLI_ASSOC);

        $nextPage = $page + 1;
        if ($nextPage > $totalPages) {
            $nextPage = 0;
        }
        $prevPage = $page - 1;
        if ($prevPage < 1) {
            $prevPage = 0;
        }

        $pagination = '';
        $pagination .= '<li class="page-item ';
        if ($prevPage == 0) {
            $pagination .= 'disabled';
        }
        $pagination .= '"><a class="page-link" href="'.$pageName.'?pagno=' . $prevPage . '"><span>&laquo;</span></a> ';
        $pagination .= '</li>';
        if ($page > $linksAfterAndBefore + 1) {
            $pagination .= '<li class="page-item"><a class="page-link" href="'.$pageName.'"><span>1</span></a></li>';
        };
        if ($page > $linksAfterAndBefore + 2) {
            $pagination .= '<li class="page-item disabled"><a class="page-link" href=""><span>...</span></a></li>';
        };
        for ($i = $page - $linksAfterAndBefore; $i <= $page; $i++) {
            if ($i > 0) {
                $pagination .= '<li class="page-item ';
                if ($i == $page) {
                    $pagination .= 'active';
                };
                $pagination .= '"><a class="page-link" href="'.$pageName.'?pagno=' . $i . '">' . $i . '</a></li>';
            }
        }
        for ($i = $page + 1; $i <= $page + $linksAfterAndBefore; $i++){
            if ($i > $totalPages - 1) {
                break;
            }
            $pagination .= '<li class="page-item ';
            if ($i == $page) {
                $pagination .= 'active';
            };
            $pagination .= '"><a class="page-link" href="'.$pageName.'?pagno=' . $i . '">' . $i . '</a></li>';
        }
        if ($page + $linksAfterAndBefore + 1  < $totalPages ){
            $pagination .= '<li class="page-item disabled"><a class="page-link" href=""><span>...</span></a></li>';
        }
        if ($page != $totalPages ){
            $pagination .= '<li class="page-item">
                                <a class="page-link" href="'.$pageName.'?pagno='.$totalPages.'">
                                    <span aria-hidden="true">'.$totalPages.'</span>
                                </a>
                            </li>';
        }
        $pagination .= '<li class="page-item ';
        if ($nextPage == 0){$pagination .= 'disabled';}
        $pagination .= '"><a class="page-link" href="'.$pageName.'?pagno='.$nextPage.'">
                                &raquo;
                            </a>
                        </li>';


        return [
            'sql_result' => $result,
            'page'       => $page,
            'total_pages' => $totalPages,
            'pagination' => $pagination
        ];
    }

}