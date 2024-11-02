<?php
// Specify the directory where your PHP files are located
$directory = __DIR__;

// Get all PHP files in the directory
$phpFiles = glob($directory . '/../php-class/*.php');
// Include each PHP file
foreach ($phpFiles as $file) {
    include_once $file;
}

// // for admin account
// // *****update is automatically execute for 1st time site load
// $user = new User();
// $user->setValue("admin", "admin", "admin", "0", "0", "0", "0", "0", "0", "0", "0");
// $user->password = "admin@admin";
// $user->password = password_hash($user->password, PASSWORD_DEFAULT);
// $user->createUser();

// // for teacher id
// $user = new User();
// $user->setValue("teacher", "A Arafat", "a.cse@just.edu.bd", "+8801835866504", "Computer Science And Engineering", "B+", "male", "166/1 Narayangonj, Dhaka.", "0", "0", "0");
// $user->createUser();
// $user->setValue("teacher", "T Arisha", "t.cse@just.edu.bd", "+88016760575408", "Computer Science And Engineering", "O+", "female", "Khulna45/6", "0", "0", "0");
// $user->createUser();

// echo "2 Teacher created <br>";


// $student = new Student();

// $studentsData = [
//     ["Amir Raza Ahad", "170115", "Palbari", "A+", "01684227523"],
//     ["Md.Abdul Maruf Siddiki", "170150", "Jashore University of Science and Technology", "o+", "01785214488"],
//     ["MD Nafiur Rahman", "170151", "Ambottola", "B+", "01521257588"],
//     ["Nahid Karim Emon", "180103", "Churamonkathi", "AB+", "01956351793"],
//     ["Abdul Wakil", "180105", "Ambottola", "B+", "01757255491"],
//     ["Badsha Ali", "180112", "Nilgong Suparibagan", "AB+", "01757166360"],
//     ["Mahmudul Hossain", "180119", "Ambortola", "A+", "01756348095"],
//     ["Mahbuba Islam Priya", "180142", "Sheikh Hasina Hall, JUST", "B+", "01776860744"],
//     ["Shakil Hossain", "180143", "Main Varsity Gate", "O+", "01884385151"],
//     ["Md Mosiur Rahman Romel", "180149", "Shahid Mashiur Rahman Hall,Jashore University of Science and Technology", "A+", "01780383246"],
//     ["Md. Zannatul Hassan Aotmick", "180151", "Just Hall", "A+", "01622684151"],
//     ["Tanvir Hossain", "190113", "Palbari S.M.R Hall", "A+", "01971636762"],
//     ["M.A. RAFI", "190114", "Murali Shaheed Mashiur Rahman Hall, Jashore University of Science and Technology", "B+", "+8801825787472"],
//     ["Masrafe Bin Seraj Sakib", "190116", "Shaheed Mosiur Rahman Hall Dharmotola, Jashore", "O+", "01744110978"],
//     ["Nitay Chandra Das Sadia Islam", "190118", "Ghoshpara Road,Palbari Dharmatala", "O+", "01704305651"],
//     ["Mohibul Hasan Refat", "190119", "SMRH, JUST Arobpur road, Jashore sadar.", "O+", "+8801878038097"],
//     ["Abdul khaled Arafat", "190122", "Palbari, jashore.", "B+", "01835866504"],
//     ["Tasnuba Tasnim", "190135", "SMRH, JUST Arobpur road, Jashore sadar.", "O+", "01612312312"]
// ];

// // Loop to create each student
// foreach ($studentsData as $data) {
//     $student = new Student();
//     $student->setValue("student", $data[0], "{$data[1]}.cse@student.just.edu.bd", $data[4], "Computer Science And Engineering", $data[3], "male", $data[2], $data[1], "2019-2020", "{$data[1]}.00");
//     $student->createStudent();
// }

// echo "Students created successfully! <br>";


// $course = new CourseDetails();
// $coursesData = [
//     [2, "2019-2020", "Computer Science And Engineering", "CSE1101", "C Programming", 3],
//     [2, "2019-2020", "Computer Science And Engineering", "CSE1102", "C Programming Lab", 1.5],
//     [2, "2019-2020", "Computer Science And Engineering", "CSE1103", "Data Structures and Algorithms", 3],
//     [2, "2019-2020", "Computer Science And Engineering", "CSE1104", "Algorithms Lab", 1.5],
//     [2, "2019-2020", "Computer Science And Engineering", "CSE1105", "Database Management Systems", 3],
//     [2, "2019-2020", "Computer Science And Engineering", "CSE3301", "Database Systems Lab", 1.5],
//     [2, "2019-2020", "Computer Science And Engineering", "CSE4401", "Software Engineering", 3],
//     [2, "2019-2020", "Computer Science And Engineering", "CSE4402", "Software Engineering Lab", 1.5],
//     [2, "2019-2020", "Computer Science And Engineering", "CSE5501", "Machine Learning Fundamentals", 3],
//     [2, "2019-2020", "Computer Science And Engineering", "CSE5502", "Machine Learning Lab", 1.5],
// ];


// foreach ($coursesData as $d) {
//     $course = new CourseDetails();
//     $course->setValue($d[0], $d[1], $d[2], $d[3], $d[4], $d[5]);
//     $course->createCourse();
// }

// echo "Courses created successfully!";


// $en = new CourseEnroll();
// $st = new Student();

// for ($i=4; $i <21 ; $i++) { 
//     $st->user_id = $i;
//     $st->readStudent();

//     for ($j=1; $j < 11; $j++) { 
//         $en->enrollStudent($st->student_id, $j);
//     }

// }

// echo "Enroll done";






?>

<!--  -->