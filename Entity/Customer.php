<?php

namespace Disjfa\DemoBundle\Entity;

use Oro\Bundle\AccountBundle\Entity\Account;
use Oro\Bundle\BusinessEntitiesBundle\Entity\BasePerson;
use Oro\Bundle\ContactBundle\Entity\Contact;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\MagentoBundle\Entity\IntegrationEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="demo_customer",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="unq_remote_id_channel_id", columns={"remote_id", "channel_id"})}
 * )
 * @Config()
 */
class Customer extends BasePerson
{
    use IntegrationEntityTrait;

    /**
     * @var integer
     * @ConfigField(
     *     defaultValues={
     *          "importexport"={
     *              "identity"=true
     *         }
     *     }
     * )
     * @ORM\Column(name="remote_id", type="integer", options={"unsigned"=true}, nullable=false)
     */
    private $remoteId;


    /**
     * @var Contact
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\ContactBundle\Entity\Contact", cascade={"PERSIST"})
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $contact;

    /**
     * @var Account
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\AccountBundle\Entity\Account", cascade={"PERSIST"})
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $account;

    /**
     * @return int
     */
    public function getRemoteId()
    {
        return $this->remoteId;
    }

    /**
     * @param int $remoteId
     */
    public function setRemoteId($remoteId)
    {
        $this->remoteId = $remoteId;
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }
}