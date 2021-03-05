-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2021 at 06:04 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `idiscuss`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_Name` varchar(255) NOT NULL,
  `category_descripation` varchar(355) NOT NULL,
  `category_Creation_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_Small_descripation` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_Name`, `category_descripation`, `category_Creation_data`, `category_Small_descripation`) VALUES
(1, 'Python', 'Python is an interpreted, high-level and general-purpose programming language. Python\'s design philosophy emphasizes code readability with its notable use of significant whitespace.', '2020-11-24 02:36:54', 'Programing Laungauge'),
(2, 'JavaScript', 'JavaScript, often abbreviated as JS, is a programming language that conforms to the ECMAScript specification. JavaScript is high-level, often just-in-time compiled, and multi-paradigm. It has curly-bracket syntax, dynamic typing, prototype-based object-orientation, and first-class functions. ', '2020-11-24 02:37:35', 'Front End Scripting Langauge'),
(3, 'PHP', 'PHP is a general-purpose scripting language especially suited to web development. It was originally created by Danish-Canadian programmer Rasmus Lerdorf in 1994. The PHP reference implementation is now produced by The PHP Group.', '2020-11-24 02:38:06', 'BackEnd Scripting Languge'),
(4, 'Hacking', 'A security hacker is someone who explores methods for breaching defenses and exploiting weaknesses in a computer system or network.', '2020-11-24 02:38:29', 'Hacking'),
(5, 'HTML', 'Hypertext Markup Language is the standard markup language for documents designed to be displayed in a web browser. It can be assisted by technologies such as Cascading Style Sheets and scripting languages such as JavaScript.', '2020-11-24 03:23:32', 'Hyper Text Markup Langauge'),
(6, 'Css', 'Cascading Style Sheets is a style sheet language used for describing the presentation of a document written in a markup language such as HTML. CSS is a cornerstone technology of the World Wide Web, alongside HTML and JavaScript.', '2020-11-24 23:54:10', 'Cascading Style Sheets'),
(7, 'SQL', 'SQL is a domain-specific language used in programming and designed for managing data held in a relational database management system, or for stream processing in a relational data stream management system. ', '2020-11-24 23:55:23', 'Programming language'),
(8, 'jQuery', 'jQuery is a JavaScript library designed to simplify HTML DOM tree traversal and manipulation, as well as event handling, CSS animation, and Ajax. It is free, open-source software using the permissive MIT License. As of May 2019, jQuery is used by 73% of the 10 million most popular websites.', '2020-11-25 00:01:07', 'Software'),
(9, 'AngularJS', 'AngularJS is a JavaScript-based open-source front-end web framework mainly maintained by Google and by a community of individuals and corporations to address many of the challenges encountered in developing single-page applications.', '2020-11-25 00:02:32', 'front-end web framework ');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(8) NOT NULL,
  `comment_content` text NOT NULL,
  `thread_id` int(11) NOT NULL,
  `comment_by` int(8) NOT NULL,
  `comment_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES
(1, 'There are many resources from you can learn python but if you are unable to find then I will suggest you some name these are : \r\n1. Youtube\r\n2. Udemy\r\n3. Edureka (very Expensive)\r\n4. Google \r\n5. From Microsoft,google Free Cources\r\n', 1, 4, '2020-12-01 00:51:22'),
(2, 'I think that Youtube is best way to learn any thing in this world ', 1, 4, '2020-12-02 00:28:40'),
(6, 'You can learn from many free cources like Youtube free cources, Udemy free cources, Courcera Free Cources etc', 1, 3, '2020-12-02 00:48:36'),
(7, 'There are many advantages of learning Python. I will show you some \r\n1. You Can Create Website \r\n2. You can Do ML (machine Learning)\r\n3. You Can Do AI (Artifical Intillegence)\r\n4. You Can Create Mobile Apps\r\n5. Easy to learn \r\netc...', 3, 3, '2020-12-04 08:39:10');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `thread_id` int(7) NOT NULL,
  `thread_title` varchar(255) NOT NULL,
  `thread_descrapation` text NOT NULL,
  `thread_cat_id` int(7) NOT NULL,
  `thread_user_id` int(7) NOT NULL,
  `date_of_adding_question` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`thread_id`, `thread_title`, `thread_descrapation`, `thread_cat_id`, `thread_user_id`, `date_of_adding_question`) VALUES
(1, 'How to learn python', 'Hello eveyone I m unable to find the best path for learning programing please help me at this case', 1, 3, '2020-11-27 22:16:40'),
(2, 'Is python is sutable for me ?', 'I am a C programmer and now i want to learn python then my question is that is python is sutable for me or not.\r\n', 1, 3, '2020-11-27 22:18:21'),
(3, 'What is Advantage of Learning Python', 'Hello Everyone i m new in programing and i want to learn python so please tell that what is advangages of learning python and is python is good for my future programing carrer.', 1, 3, '2020-11-30 07:51:28'),
(4, 'What is Python ?', 'Hello Everyone, I m new in programing and i want to start Programing with Python because I heard about this a lot so please tell that what is python.', 1, 3, '2020-11-30 08:00:27'),
(16, 'fghfgh', 'fdghfgh', 2, 3, '2020-11-30 08:38:45'),
(17, 'This is good', 'this is good\r\n', 1, 3, '2020-12-01 01:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `sno` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Date of Joining` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`sno`, `username`, `password`, `Date of Joining`) VALUES
(3, 'Yogesh', '$2y$10$E6RA826rwJNs.Na.jllgR.NCM2xeqggfSrY.3Uw9bv2gsii4bAVdO', '2020-11-26 07:34:54'),
(4, 'Lovemekknot', '$2y$10$pyuYDnR8IS.EsdjOZe1PHOUxXMmyzlkP282zyjp4LKoBD88Zkv6GO', '2020-11-26 08:10:00'),
(6, 'Harry', '$2y$10$hRlJKxd00DSlLY4AxjMCzO4mb2uBzAb4cCOF4j25KJwEbgqwN0rMa', '2020-11-27 07:33:44'),
(8, 'hacker', '$2y$10$mVTCduYsUJ9WI8CcVi38jO0gMURUcbihqVgHEpeyu0khetGz6soHW', '2020-11-28 23:52:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`thread_id`);
ALTER TABLE `threads` ADD FULLTEXT KEY `thread_title` (`thread_title`,`thread_descrapation`);
ALTER TABLE `threads` ADD FULLTEXT KEY `thread_title_2` (`thread_title`,`thread_descrapation`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `thread_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
