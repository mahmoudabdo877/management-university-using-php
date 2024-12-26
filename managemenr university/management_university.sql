-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 07:35 PM
-- Server version: 9.0.0
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `management university`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `assign_id` int NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `due_date` date NOT NULL,
  `course_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`assign_id`, `title`, `due_date`, `course_id`) VALUES
(13, 'mahmodu?', '2024-12-19', 5),
(14, 'jiojsdds', '2024-12-18', 5);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int NOT NULL,
  `course_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `credit` int NOT NULL,
  `dept_id` int DEFAULT NULL,
  `instructor_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `credit`, `dept_id`, `instructor_id`) VALUES
(5, 'Introduction to Programming', 3, 1, 7),
(6, 'Advanced Mathematics', 4, 2, 7),
(7, 'Quantum Physics', 3, 3, 9),
(8, 'Cell Biology', 3, 4, 13),
(16, 'network', 2, 2, 13),
(17, 'network2', 3, 1, 13),
(18, 'network2', 3, 1, 13),
(19, 'network2', 3, 1, 13),
(20, 'network2', 3, 1, 13),
(21, 'python', 3, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int NOT NULL,
  `dept_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `head` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `dept_name`, `head`) VALUES
(1, 'CSE', 7),
(2, 'ECE', 8),
(3, 'ACE', 9),
(4, 'PEM', 13);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `student_id` int NOT NULL,
  `course_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`student_id`, `course_id`) VALUES
(1, 5),
(2, 5),
(1, 6),
(4, 6),
(1, 7),
(1, 16),
(1, 18),
(1, 19),
(1, 21);

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `grade_id` int NOT NULL,
  `grade_gpa` decimal(4,2) DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL
) ;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`grade_id`, `grade_gpa`, `student_id`, `course_id`) VALUES
(5, 3.50, 1, 5),
(6, 3.80, 2, 6),
(7, 2.90, 3, 7),
(8, 3.20, 4, 8),
(9, 3.00, 2, 5),
(10, 0.80, 2, 6),
(11, 4.00, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `instructor_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `dept_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`instructor_id`, `name`, `email`, `phone`, `dept_id`) VALUES
(7, 'Dr. Al-Husseini', 'alHusseini@university.com', '01011122334', 1),
(8, 'Dr. marwa Samy', 'marwa@university.com', '01122334455', 2),
(9, 'Dr. moha,ed Saeed', 'mohamed@university.com', '01233445566', 3),
(13, 'Dr. MAHMOUD ABDO', 'MAHMOUD@university.com', '01066962343', 4),
(14, 'hoda', 'hoda123@gmail.com', '01066962343', 1),
(15, 'hodaaa', 'mahmoudabdo8778@gmail.com', '01066962343', 2);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('Student','Instructor','Admin') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `instructor_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `username`, `password`, `role`, `student_id`, `instructor_id`) VALUES
(10, 'Ahmed', 'password123', 'Student', 1, NULL),
(11, 'mohamed', 'password456', 'Student', 2, NULL),
(12, 'alhusseini', 'password123', 'Instructor', NULL, 7),
(13, 'marwa', 'password789', 'Instructor', NULL, 8),
(14, 'mahmoud', 'password123', 'Instructor', NULL, 13),
(15, 'mohamedberbar', 'password123', 'Admin', NULL, NULL),
(16, 'admin2', 'password123', 'Admin', NULL, NULL),
(17, 'admin3', 'password3123', 'Admin', NULL, NULL),
(18, 'admin4', 'password4123', 'Admin', NULL, NULL),
(19, 'mah', 'password123', 'Instructor', NULL, 14),
(20, 'nader', 'password123', 'Student', 5, NULL),
(26, 'mahaaa', 'password123', 'Instructor', NULL, 15),
(27, 'naderaaa', 'password123', 'Student', 11, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `sch_id` int NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `room` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `course_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`sch_id`, `date`, `time`, `room`, `course_id`) VALUES
(9, '2024-12-22', '09:00:00', 'Room 101', 5),
(10, '2024-12-22', '11:00:00', 'Room 102', 6),
(11, '2024-12-23', '14:00:00', 'Room 201', 7),
(12, '2024-12-23', '16:00:00', 'Room 202', 8);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Student_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `age` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_id`, `name`, `age`, `email`, `phone`, `gender`) VALUES
(1, 'Ahmed Ali', 21, 'ahmed@example.com', '01012345678', 'Male'),
(2, 'Sara Mohamed', 22, 'sara@example.com', '01098765432', 'Female'),
(3, 'Mona Khaled', 23, 'mona@example.com', '01123456789', 'Female'),
(4, 'Ali Hassan', 20, 'ali@example.com', '01234567890', 'Male'),
(5, 'nader', 15, 'sss@gmail.com', '018548486464', 'Male'),
(6, 'nader', 15, 'sss@gmail.com', '018548486464', 'Male'),
(7, 'nader', 15, 'sss@gmail.com', '018548486464', 'Male'),
(8, 'nader', 15, 'sss@gmail.com', '018548486464', 'Male'),
(9, 'naderaa', 21, 'mahmoudabdo8778@gmail.com', '018548486464', 'Male'),
(10, 'naderaa', 21, 'mahmoudabdo8778@gmail.com', '018548486464', 'Male'),
(11, 'naderaa', 22, 'mahmoudabdo8778@gmail.com', '018548486464', 'Male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`assign_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `fk_instructor` (`instructor_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`),
  ADD UNIQUE KEY `unique_head` (`head`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`student_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`instructor_id`),
  ADD KEY `dept_id` (`dept_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`sch_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `assign_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `grade_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `instructor_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `sch_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `Student_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`),
  ADD CONSTRAINT `fk_instructor` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `fk_head` FOREIGN KEY (`head`) REFERENCES `instructor` (`instructor_id`);

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`Student_id`),
  ADD CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `grade_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`Student_id`),
  ADD CONSTRAINT `grade_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `instructor`
--
ALTER TABLE `instructor`
  ADD CONSTRAINT `instructor_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`);

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`Student_id`),
  ADD CONSTRAINT `login_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
