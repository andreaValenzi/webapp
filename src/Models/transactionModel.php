<?php
class TransactionModel {
    function __construct(){
      
    }

    public function getTransactions(){
        $pdo = new PDO('mysql:host=database;dbname=test', 'andrea', 'ciaone');
        $statement = $pdo->query("SELECT 
        transactions.id as tid,
        transactions.user_id as uid,
        transactions.amount as amount,
        transactions.currency as currency,
        products.id as pid,
        products.description as description
        from transactions, products where transactions.product_id = products.id");
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $objects = array_map('toDto', $rows);
        return json_encode($objects);
    }

    public function deleteTransaction($id) {
        $pdo = new PDO('mysql:host=database;dbname=test', 'andrea', 'ciaone');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM transactions WHERE id=" . $id;
        $pdo->exec($sql);
        return json_encode([]);
    }
}

function toDto($elem)
{
    $object = [
        'id' => $elem['tid'],
        'user_id' => $elem['uid'],
        'product' => [
            'id' => $elem['pid'],
            'description' => $elem['description']
        ],
        'amount' => $elem['amount'],
        'currency' => $elem['currency']
    ];

    return $object;
}