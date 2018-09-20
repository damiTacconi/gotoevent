<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 15:55
 */

namespace Dao;


interface IDao
{
    public function save($data);
    public function update($data);
    public function delete($data);
    public function retrieve($id);
}