<?php

# Унаследованный контроллер

class IndexController extends Controller {
    # Подключаем шаблоны

    private $pageTpl = "/views/interface.php";
    private $pageTpl_back = "/views/tab_one.php";

    # Создаем в конструкторе новую модель и вид

    public function __construct() {

        $this->model = new IndexModel();
        $this->view = new View();
    }

    # Метод по умолчанию

    public function index() {

        $this->view->render($this->pageTpl, $this->pageData);
    }

    # Метод получения информации для передачи в шаблон

    public function menu() {

        # Заголовок меню    

        $this->pageData['title'] = "Меню";

        # Обращаемся к модели для получения списка скопированных из Википедии статей

        $info = $this->model->menu();
        $this->pageData['info'] = $info;

        # Обращаемся к модели для получения информации о найденных совпадениях по словам-атомам
        # Если массив POST не пустой, получаем из него слово атом

        if (!empty($_POST['search'])) {
            $search = $_POST['search'];

            # Если массив POST пустой, тогда слово атом пустое
        } else {
            $search = "";
        }

        # Передаем модели слово-атом

        $search_result = $this->model->search($search);

        # Записываем полученный из модели результат в массив pageData (Заголовки статей и количество совпадений по словам атомам)

        $this->pageData['search'] = $search_result;

        # Обращаемся к модели для получения содержимого статьи
        # Если массив POST не пустой, получаем из него заголовок для последующего поиска статьи

        if (!empty($_POST['heading'])) {
            $heading = $_POST['heading'];

            #Обращаемся к модели для передачи значения и получения результата с последующей записью в массив pageData

            $heading_result = $this->model->intelligence($heading);
            $this->pageData['intelligence'] = $heading_result;

            # Если массив POST пуст, тогда записываем в массив pageData текст                  
        } else {

            $this->pageData['intelligence'] = ["content" => "Содержимое статьи при нажатии на кнопку"];
        }

        # Передаем в представление шаблон и массив pageData для корректного отображения меню      

        $this->view->render($this->pageTpl_back, $this->pageData);
    }

    # Метод для копирования информации из Википедии

    public function wiki() {

        # Получаем искомое слово из массива POST    

        $inquiry = $_POST['value'];

        # Передаем искомое слово в модель

        $this->model->wiki($inquiry);

        # Выводим сообщение для пользователя

        echo "Данные скопированны";
    }

}
