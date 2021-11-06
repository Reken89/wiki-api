<?php

# Унаследованная модель

class IndexModel extends Model {
    # Метод по умолчанию (пустой)

    public function index() {
        
    }

    # Метод для получения информации из БД для корректного отображения меню
    # Получаем информацию о количестве статей в БД и заносим полученную информацию в массив res

    public function menu() {

        $sql = "SELECT artid, heading FROM articles";
        $res = [];
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[$row['artid']] = $row;
        }

        # Возвращаем результат в контроллер

        return $res;
    }

    # Метод для получения информации из Википедии по искомому слову

    public function wiki($inquiry) {

        # Выполняем копирование используя API MediaWiki согласно инсрукции с официально сайта Википедии    

        $endPoint = "https://ru.wikipedia.org/w/api.php";
        $params = [
            "action" => "parse",
            "page" => "$inquiry",
            "format" => "json"
        ];

        $url = $endPoint . "?" . http_build_query($params);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($output, true);

        # Подготавливаем полученный контент для записи в БД (убираем тэги)

        $content = ( strip_tags($result["parse"]["text"]["*"]));

        $content = preg_replace('|\s+|', ' ', $content);

        # Заполняем таблицу articles (Заголовки и содержимое статьи)
        $sql = "INSERT INTO articles (content, heading) VALUES ('$content', '$inquiry')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        #Заполняем таблицу words (Слова-атомы и количество повторяющихся слов в статье)
        # Рзбиваем результат запроса с Википедии в массив

        $content_array = preg_replace("/[^a-zа-яё0-9\s]%u/i", '', $content);
        $content_array = preg_split('/(\s)/', $content_array);
        $content_array = array_diff($content_array, array(''));

        # Объединяем одинаковые значения в массиве

        $count = array_count_values($content_array);

        # !!!ИСПОЛЬЗУЯ ЦИКЛ записываем значения в БД (НЕОБХОДИМО ДОРАБОТАТЬ МЕТОД ЗАПИСИ, ЧТО БЫ НЕ ИСПОЛЬЗОВАТЬ SQL ЗАПРОС В ЦИКЛЕ)

        foreach ($count as $key => $value) {

            $sql = "INSERT INTO words (word, coincidence, heading) VALUES ('$key', '$count[$key]', '$inquiry')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        }

        #Заполняем таблицы connection (связующая таблица)

        $sql = "INSERT INTO connection (artid, wordid, coincidence) SELECT s.artid, b.wordid, b.coincidence FROM articles AS s, words AS b WHERE s.heading = '$inquiry' AND b.heading = '$inquiry'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    # Метод для получения информации о количестве совпадений в статье по словам атомам
    # Полученные результат записываем в массив и возвращаем в контроллер

    public function search($search) {

        $sql = "SELECT wordid, coincidence, heading FROM words WHERE word = '$search' order by coincidence DESC";

        $res = [];
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[$row['wordid']] = $row;
        }

        return $res;
    }

    # Мктод для получения содержимого статьи по заголовку статьи
    # Полученные результат записываем в массив и возвращаем в контроллер

    public function intelligence($heading) {

        $sql = "SELECT heading, content FROM articles WHERE heading = '$heading'";

        $res = [];
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            $res = $row;
        }

        return $res;
    }

}
