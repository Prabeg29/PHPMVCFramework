<?php

namespace app\Core\DB;

abstract class UserModel extends DbModel {
    abstract public function getDisplayName(): string;
}