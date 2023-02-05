<?php
    $example_persons_array = [
        [
            'fullname' => 'Иванов Иван Иванович',
            'job' => 'tester',
        ],
        [
            'fullname' => 'Степанова Наталья Степановна',
            'job' => 'frontend-developer',
        ],
        [
            'fullname' => 'Пащенко Владимир Александрович',
            'job' => 'analyst',
        ],
        [
            'fullname' => 'Громов Александр Иванович',
            'job' => 'fullstack-developer',
        ],
        [
            'fullname' => 'Славин Семён Сергеевич',
            'job' => 'analyst',
        ],
        [
            'fullname' => 'Цой Владимир Антонович',
            'job' => 'frontend-developer',
        ],
        [
            'fullname' => 'Быстрая Юлия Сергеевна',
            'job' => 'PR-manager',
        ],
        [
            'fullname' => 'Шматко Антонина Сергеевна',
            'job' => 'HR-manager',
        ],
        [
            'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
            'job' => 'analyst',
        ],
        [
            'fullname' => 'Бардо Жаклин Фёдоровна',
            'job' => 'android-developer',
        ],
        [
            'fullname' => 'Шварцнегер Арнольд Густавович',
            'job' => 'babysitter',
        ],
    ];
    //принимает как аргумент три строки — фамилию, имя и отчество. Возвращает как результат их же, но склеенные через пробел.
    function getFullnameFromParts($str1, $str2, $str3) {
        return $str1.' '.$str2.' '.$str3;
    }

    // Функция сборки полного имени из частей
    $index = mt_rand(0, 10);
    function getPartsFromFullname($fullname){
        $arr = explode(' ', $fullname);
        return ['surname' => $arr[0] ,'name' => $arr[1], 'patronomyc' => $arr[2]];
    }

    // var_dump (getPartsFromFullname($example_persons_array[$index]['fullname']));

    // Сокращение ФИО
    function getShortName($fullname){
        $arr = getPartsFromFullname($fullname);
        return $arr['name'].' '.mb_substr($arr['surname'], 0, 1).'.';
    } 

    // var_dump (getShortName($example_persons_array[$index]['fullname']));

    //Функция определения пола по ФИО

    function getGenderFromName($fullname){
        $gender = 0;
        $arr = getPartsFromFullname($fullname);
        //признаки женского пола
        if(mb_substr($arr['patronomyc'], -3) === 'вна'){
            $gender--;
        }
        if(mb_substr($arr['name'], -1) === 'а'){
            $gender--;
        }
        if(mb_substr($arr['surname'], -2) === 'ва'){
            $gender--;
        }
        //признаки мужского пола
        if(mb_substr($arr['patronomyc'], -2) === 'ич'){
            $gender++;
        }
        if(mb_substr($arr['name'], -1) === 'й' || mb_substr($arr['name'], -1) === 'н'){
            $gender++;
        }
        if(mb_substr($arr['surname'], -1) === 'в'){
            $gender++;
        }
        if ($gender >=1) {
            $gender = 1;
        } elseif ($gender >=0) {
            $gender = 0;
        } else {
            $gender = -1;
        }
        return $gender; 
    }

     // var_dump (getGenderFromName($example_persons_array[$index]['fullname']));

     //Функция определения возрастно-полового состава
     function getGenderDescription($arr){
        $male = 0;
        $female = 0;
        $count = 0;
        foreach($arr as $value){
            if (getGenderFromName($value['fullname']) === 1){
                $male++;
            }
            if (getGenderFromName($value['fullname']) === -1){
                $female++;
            } 
            $count++;
        }
        $text = "Гендерный состав аудитории: \n --------------------------- \n Мужчины - ";
        $text .= round($male * 100 / $count, 1);
        $text .=  "% \n Женщины - ";
        $text .= round($female * 100 / $count, 1);
        $text .= "% \n Не удалось определить - ";
        $text .= round(($count - $male - $female) *100 / $count, 1) . "%\n";
        echo $text;
}
    getGenderDescription($example_persons_array);

    //Подбор идеальной пары

    function getPerfectPartner($name, $surname, $patronomyc, $arr){
        $fullname = getFullnameFromParts(transformString($name), transformString($surname), transformString($patronomyc));
        $gender = getGenderFromName($fullname);
        do{
            $index = mt_rand(0, 10);
            $fullname2 = ($arr[$index]['fullname']);
            $gender2 = getGenderFromName($fullname2);
        }
        while($gender === $gender2 || $gender2 === 0);
        
        $result = getShortName($fullname)." + ". getShortName($fullname2). " = ";
        $result .= "\n ♡ Идеально на ".round(mt_rand(5000, 10000)/100, 2)."% ♡";
        echo $result;
    }
        
    function transformString($str) {
        $str = mb_strtoupper(mb_substr($str, 0, 1)).mb_strtolower(mb_substr($str, 1, mb_strlen($str)));
        return $str;
    }

    getPerfectPartner('Иванов', 'ИВАН', 'ИвАнОвИч', $example_persons_array)

?>
