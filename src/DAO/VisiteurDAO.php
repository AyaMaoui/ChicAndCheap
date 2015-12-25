<?php

namespace ChicAndCheap\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use ChicAndCheap\Domain\Visiteur;


class VisiteurDAO extends DAO implements UserProviderInterface
{
    /**
     * Returns a user matching the supplied id.
     *
     * @param integer $id The user id.
     *
     * @return \ChicAndCheap\Domain\User|throws an exception if no matching user is found
     */
    public function find($id) {
        $sql = "select * from visiteur where id_visiteur=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No user matching id " . $id);
    }

    /**
     * {@inheritDoc}
     */
public function loadUserByUsername($username)

    {
        $sql = "select * from visiteur where login_visiteur=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));


        if ($row)

            return $this->buildDomainObject($row);
        else

            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
  }
    /**
    * {@inheritDoc}
    */

    public function refreshUser(UserInterface $user)

    {
        $class = get_class($user);

        if (!$this->supportsClass($class)) {

            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        return $this->loadUserByUsername($user->getUsername());
  }
    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'ChicAndCheap\Domain\Visiteur' === $class;
    }

    /**
     * Creates a User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * 
     */
    protected function buildDomainObject($row) {
        $visiteur= new Visiteur();
        $visiteur->setId($row['id_visiteur']);
        $visiteur->setUsername($row['login_visiteur']);
        $visiteur->setPassword($row['pwd_visiteur']);
        $visiteur->setSalt($row['salt']);
        $visiteur->setRole($row['role']);
        return $visiteur;
    }
}