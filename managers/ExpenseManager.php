<?php

class ExpenseManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(Expense $expense): void
    {
        $query = $this->db->prepare("INSERT INTO expenses(amount_100, id_user, id_category, motif) VALUES(:amount_100, :id_user, :id_category, :motif)");
        $parameters = [
            "amount_100" => $expense->getAmount(),
            "id_user" => $expense->getUser(),
            "id_category" => $expense->getCategory(),
            "motif" => $expense->getMotif()
        ];

        $query->execute($parameters);
    }

    public function update(Expense $expense): void
    {
        $query = $this->db->prepare("UPDATE expenses SET amount_100=:amount_100, id_user=:id_user, id_category=:id_category, motif=:motif WHERE id=:id");
        $parameters = [
            "id" => $expense->getId(),
            "amount_100" => $expense->getAmount(),
            "id_user" => $expense->getUser(),
            "id_category" => $expense->getCategory(),
            "motif" => $expense->getMotif()
        ];

        $query->execute($parameters);
    }

    public function delete(Expense $expense): void
    {
        $query = $this->db->prepare("DELETE FROM expenses WHERE id=:id");
        $parameters = [
            "id" => $expense->getId()
        ];

        $query->execute($parameters);
    }

    public function findOne($id): Expense
    {
        $query = $this->db->prepare("SELECT * FROM expenses WHERE id=:id");
        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        $expense = $query->fetch(PDO::FETCH_ASSOC);

        return new Expense($expense['amount_100'], $expense['id_user'], $expense['id_category'], $expense['motif'], $expense['id']);
    }

    public function findAll(): array
    {
        $query = $this->db->prepare("SELECT * FROM expenses ORDER BY id DESC");

        $query->execute();
        $expenses = $query->fetchAll(PDO::FETCH_ASSOC);

        $all_expenses = [];

        foreach ($expenses as $expense) {
            $all_expenses[] = new Expense($expense['amount_100'], $expense['id_user'], $expense['id_category'], $expense['motif'], $expense['id']);
        }

        return $all_expenses;
    }
}