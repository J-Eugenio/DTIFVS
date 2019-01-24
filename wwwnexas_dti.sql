-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 09-Nov-2018 às 16:24
-- Versão do servidor: 5.6.41-84.1
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wwwnexas_dti`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bug`
--

CREATE TABLE `bug` (
  `idBug` int(11) NOT NULL,
  `titulo` varchar(120) NOT NULL,
  `descricao` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `devolucao`
--

CREATE TABLE `devolucao` (
  `idDevolucao` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `reserva` int(11) NOT NULL,
  `datadevolucao` date NOT NULL,
  `horadevolucao` time NOT NULL,
  `devolucao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `recurso`
--

CREATE TABLE `recurso` (
  `id` int(11) NOT NULL,
  `nome` varchar(70) NOT NULL,
  `descricao` varchar(100) DEFAULT ' ',
  `tipo` int(11) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `campus` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `regras`
--

CREATE TABLE `regras` (
  `id` int(11) NOT NULL,
  `quantidadeHorariosMatutino` int(5) NOT NULL,
  `quantidadeHorariosVespertino` int(5) NOT NULL,
  `quantidadeHorariosNoturno` int(5) NOT NULL,
  `quantidadeDiasReservaveis` int(5) NOT NULL,
  `horarioInicioMatutino` date NOT NULL,
  `horarioInicioVespertino` date NOT NULL,
  `horarioInicioNoturno` date NOT NULL,
  `tempoDuracaoMaximo` date NOT NULL,
  `quantidadeHorariosSeguidos` int(11) NOT NULL,
  `quantidadeIntervalosEntreHorarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva`
--

CREATE TABLE `reserva` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `turno` varchar(50) NOT NULL,
  `usuario` int(11) NOT NULL,
  `equipamento` int(11) NOT NULL,
  `sala` varchar(70) NOT NULL,
  `campus` varchar(70) NOT NULL,
  `horainicio` varchar(10) NOT NULL,
  `horafim` varchar(10) NOT NULL,
  `entregue` tinyint(1) NOT NULL DEFAULT '0',
  `dataentregue` date NOT NULL,
  `horaentregue` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tiporecurso`
--

CREATE TABLE `tiporecurso` (
  `id` int(11) NOT NULL,
  `nome` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `nivel` int(2) NOT NULL,
  `acesso` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bug`
--
ALTER TABLE `bug`
  ADD PRIMARY KEY (`idBug`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `devolucao`
--
ALTER TABLE `devolucao`
  ADD PRIMARY KEY (`idDevolucao`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `reserva` (`reserva`);

--
-- Indexes for table `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo` (`tipo`);

--
-- Indexes for table `regras`
--
ALTER TABLE `regras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipamentos` (`equipamento`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `tiporecurso`
--
ALTER TABLE `tiporecurso`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bug`
--
ALTER TABLE `bug`
  MODIFY `idBug` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `devolucao`
--
ALTER TABLE `devolucao`
  MODIFY `idDevolucao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `regras`
--
ALTER TABLE `regras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=635;

--
-- AUTO_INCREMENT for table `tiporecurso`
--
ALTER TABLE `tiporecurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `bug`
--
ALTER TABLE `bug`
  ADD CONSTRAINT `bugreserva` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `devolucao`
--
ALTER TABLE `devolucao`
  ADD CONSTRAINT `devolucao_ibfk_1` FOREIGN KEY (`reserva`) REFERENCES `reserva` (`id`),
  ADD CONSTRAINT `devolucaousuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `recurso`
--
ALTER TABLE `recurso`
  ADD CONSTRAINT `recursotipo` FOREIGN KEY (`tipo`) REFERENCES `tiporecurso` (`id`);

--
-- Limitadores para a tabela `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `equipamentorecurso` FOREIGN KEY (`equipamento`) REFERENCES `recurso` (`id`),
  ADD CONSTRAINT `usuarioreserva` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
