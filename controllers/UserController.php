<?php

class UserController extends AbstractController
{
    public function home(): void
    {
        if (isset($_SESSION['id'])) {
            $category_m = new CategoryManager();

            $user_m = new UserManager();
            $user = $user_m->findOne($_SESSION['id']);

            $expense_m = new ExpenseManager();
            $expenses = $expense_m->findAll();

            $all_expenses = [];
            foreach ($expenses as $expense) {
                if ($_SESSION['id'] === $expense->getUser()) {
                    $all_expenses[] = [
                        'amount' => $expense->getAmount() / 100,
                        'category' => $category_m->findOne($expense->getCategory())->getName(),
                        'motif' => $expense->getMotif()
                    ];
                }
            }

            $refund_m = new RefundManager();
            $refunds = $refund_m->findAll();

            $all_payers = [];
            foreach ($refunds as $refund) {
                if ($refund->getReceiver() === $_SESSION['id']) {
                    $all_payers[] = [
                        "receiver_id" => $refund->getReceiver(),
                        "payer" => [$user_m->findOne($refund->getPayer())->getFirstName(), $user_m->findOne($refund->getPayer())->getLastName()],
                        "amount" => $refund->getAmount() / 100
                    ];
                }
            }

            $all_receivers = [];
            foreach ($refunds as $refund) {
                if ($refund->getPayer() === $_SESSION['id']) {
                    $all_receivers[] = [
                        "receiver" => [$user_m->findOne($refund->getReceiver())->getFirstName(), $user_m->findOne($refund->getReceiver())->getLastName()],
                        "amount" => $refund->getAmount() / 100
                    ];
                }
            }

            $total_map = [];

            foreach ($refunds as $refund) {
                if ($refund->getReceiver() === $_SESSION['id']) {
                    $payer_id = $refund->getPayer();
                    if (!isset($total_map[$payer_id])) {
                        $payer_user = $user_m->findOne($payer_id);
                        if ($payer_user) {
                            $total_map[$payer_id] = [
                                'payer_info' => [$payer_user->getFirstName(), $payer_user->getLastName()],
                                'amount' => 0
                            ];
                        }
                    }

                    if (isset($total_map[$payer_id])) {
                        $total_map[$payer_id]['amount'] += $refund->getAmount();
                    }
                }
            }

            $total = [];
            foreach ($total_map as $id => $data) {
                $total[] = [
                    "id" => $id,
                    "receiver" => $data['payer_info'],
                    "total" => $data['amount'] / 100
                ];
            }

            $this->render(
                "_home",
                [
                    "id" => $user->getId(),
                    "firstName" => $user->getFirstName(),
                    "lastName" => $user->getLastName(),
                    "user_total" => $user->getTotal() / 100,
                    "expenses" => $all_expenses,
                    "receivers" => $all_receivers,
                    "payers" => $all_payers,
                    "total" => $total
                ]
            );
        } else {
            $this->redirect('index.php');
        }
    }

    public function ajouter()
    {
        if (isset($_SESSION['id'])) {
            $user_m = new UserManager();
            $user = $user_m->findOne($_SESSION['id']);

            $this->render(
                "money/_ajouter",
                [
                    "firstName" => $user->getFirstName(),
                    "total" => $user->getTotal() / 100
                ]
            );

            if (!empty($_POST['montant']) && isset($_POST['montant'])) {
                $montant = 100 * $_POST['montant'];
                $montant = (int) $montant;
                if (gettype($montant) === "integer") {
                    $total = $user->getTotal() + $montant;
                    $user->setTotal($total);

                    $user_m->update($user);

                    $this->redirect("./index.php?route=home");
                }
            }
        } else {
            $this->redirect('./index.php');
        }
    }

    public function depenser()
    {
        if (isset($_SESSION['id'])) {
            $category_m = new CategoryManager();
            $categories = $category_m->findAll();

            $user_m = new UserManager();
            $user_ = $user_m->findOne($_SESSION['id']);

            $users = $user_m->findAll();
            $all_users = [];

            foreach ($users as $user) {
                if ($user->getId() != $_SESSION['id']) {
                    $all_users[] = [
                        "id" => $user->getId(),
                        "firstname" => $user->getFirstName(),
                        "lastname" => $user->getLastName()
                    ];
                }
            }

            $all_categories = [];

            foreach ($categories as $category) {
                $all_categories[] = [
                    "id" => $category->getId(),
                    "name" => $category->getName()
                ];
            }

            $this->render(
                "money/_depenser",
                [
                    "users" => $all_users,
                    "categories" => $all_categories,
                    "total" => $user_->getTotal() / 100
                ]
            );

            $payers = [];

            foreach ($_POST as $key => $value) {
                if (str_starts_with($key, 'payer_')) {
                    $payers[] = intval($value);
                }
            }

            if (!empty($_POST['montant']) && isset($_POST['montant']) && !empty($_POST['category']) && isset($_POST['category']) && !empty($payers) && !empty($_POST['motif']) && isset($_POST['motif'])) {
                $montant = 100 * $_POST['montant'];
                $montant = (int) $montant;
                if (gettype($montant) === "integer") {
                    $nb = count($payers) + 1;

                    $id_category = NULL;

                    foreach ($categories as $category) {
                        if ($category->getName() === $_POST['category']) {
                            $id_category = $category->getId();
                        }
                    }

                    $expense_m = new ExpenseManager();
                    $expense_m->create(new Expense($montant, $_SESSION['id'], $id_category, $_POST['motif']));

                    $total = $user_->getTotal() - $montant;

                    $user_->setTotal($total);
                    $user_m->update($user_);

                    $montant = $montant / $nb;


                    $refund_m = new RefundManager();


                    foreach ($payers as $id) {
                        $refund_m->create(new Refund($id, $_SESSION['id'], $montant));
                    }

                    $this->redirect("./index.php?route=home");
                }
            }
        } else {
            $this->redirect("./index.php");
        }
    }

    public function rembourser()
    {
        if (isset($_SESSION['id'])) {
            $user_m = new UserManager();
            $user = $user_m->findOne($_SESSION['id']);

            $category_m = new CategoryManager();

            $refund_m = new RefundManager();
            $refunds = $refund_m->findAll();

            $all_refunds = [];

            foreach ($refunds as $refund) {
                if ($refund->getPayer() === $_SESSION['id']) {
                    $all_refunds[] = [
                        "id" => $refund->getId(),
                        "receiver_firstname" => $user_m->findOne($refund->getReceiver())->getFirstName(),
                        "receiver_lastname" => $user_m->findOne($refund->getReceiver())->getLastName(),
                        "amount" => $refund->getAmount() / 100
                    ];
                }
            }


            $this->render(
                "money/_rembourser",
                [
                    "payer_firstname" => $user_m->findOne($_SESSION['id'])->getFirstName(),
                    "payer_lastname" => $user_m->findOne($_SESSION['id'])->getLastName(),
                    "total" => $user->getTotal() / 100,
                    "refunds" => $all_refunds
                ]
            );

            if (!empty($_GET['id']) && isset($_GET['id'])) {
                $refund_id = $_GET['id'];
                $refund = $refund_m->findOne($refund_id);
                $amount = $refund->getAmount();

                $payer = $user_m->findOne($refund->getPayer());
                $receiver = $user_m->findOne($refund->getReceiver());

                $payer->setTotal($payer->getTotal() - $amount);
                $receiver->setTotal($receiver->getTotal() + $amount);

                $user_m->update($payer);
                $user_m->update($receiver);

                $refund_m->delete($refund);

                $this->redirect("./index.php?route=home");
            }
        } else {
            $this->redirect("./index.php");
        }
    }
}