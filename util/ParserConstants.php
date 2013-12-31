<?php
class ParserConstants {
  
  const NAME = "name";
  const TYPE = "type";
  const LOGICAL_OP = "logicalOp";
  const GLOBAL_PANIO_STMT = "--- panio";
  const GLOBAL_PANIO_SPLIT_PATTERN = "/[---]/";
  const SAMPLING_RATE_STMT = "Elapsed time since last sampling";
  const SAMPLING_RATE_SPLIT_PATTERN = "/(\d+.\d+)/";
  const MONITOR_FILES_PATTERN = "*dp-monitor*";
  const COUNTER_STMT_SPLIT_PATTERN = "/[\s::]+/";
}
?>