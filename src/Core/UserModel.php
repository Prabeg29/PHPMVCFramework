<?php

namespace app\Core;

abstract class UserModel extends DbModel {
    abstract public function getDisplayName(): string;
}