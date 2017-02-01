<?php

class RoleMapper extends BaseDataMapper {

    protected $entityTable = "ROLE";

    /* No updating roles through the tool */
    protected function createEntity(array $row) {
        return new Role($row);
    }

}

?>
