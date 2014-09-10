<?php
class ParserConstants {
  
  const NAME = "name";
  const TYPE = "type";
  const LOGICAL_OP = "logicalOp";
  const GLOBAL_PANIO_STMT = "--- panio";
  const GLOBAL_PANIO_SPLIT_PATTERN = "/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/";
  const SAMPLING_RATE_STMT = "Elapsed time since last sampling";
  const SAMPLING_RATE_SPLIT_PATTERN = "/\d+(.\d+)?/";
  const MONITOR_FILES_PATTERN = "*dp-monitor*";
  const COUNTER_STMT_SPLIT_PATTERN = "/[\s::]+/";
  const TS_FILES_PATH = "/tmp/www/parcs/parcs_papps/ts_files"; //TS_FILES path;
  const INPUT_XML = "/tmp/www/parcs/parcs_papps/queue/papps_request-%s-input.xml"; //Request id_userid_input.xml;
  const OUTPUT_XML= "/tmp/www/parcs/parcs_papps/queue/papps_request-%s-output.xml"; //Request id_userid_input.xml;
}
?>