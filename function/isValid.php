<?php

// checks is value exists
function IsValid($id, $model) {
  $model->id = $id;
  $modelResult = $model->read_single();
  return $modelResult;
}