<?php

namespace Belkarta\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Company
 *
 * @ORM\Table(name="belkarta_company")
 * @ORM\Entity(repositoryClass="Belkarta\CompanyBundle\Entity\CompanyRepository")
 */
class Company
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="percent", type="integer")
     */
    private $percent;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="cities", type="text", nullable=true)
     */
    private $cities;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="coordinates", type="text", nullable=true)
     */
    private $coordinates;

    /**
     * @ORM\ManyToOne(targetEntity="Files\ImagesBundle\Entity\BrandLogo")
     * @ORM\JoinColumn(name="logo_id", referencedColumnName="id", nullable=true)
     */
    protected $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_user", type="string", length=255, nullable=true)
     */
    private $contactUser;

    /**
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="companies")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=true)
     */
    protected $type;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Company
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Company
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set contactUser
     *
     * @param string $contactUser
     * @return Company
     */
    public function setContactUser($contactUser)
    {
        $this->contactUser = $contactUser;

        return $this;
    }

    /**
     * Get contactUser
     *
     * @return string 
     */
    public function getContactUser()
    {
        return $this->contactUser;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Company
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set cities
     *
     * @param string $cities
     * @return Company
     */
    public function setCities($cities)
    {
        $this->cities = $cities;

        return $this;
    }

    /**
     * Get cities
     *
     * @return string 
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Set logo
     *
     * @param \Files\ImagesBundle\Entity\BrandLogo $logo
     * @return Company
     */
    public function setLogo(\Files\ImagesBundle\Entity\BrandLogo $logo = null)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return \Files\ImagesBundle\Entity\BrandLogo 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set type
     *
     * @param \Belkarta\CompanyBundle\Entity\Type $type
     * @return Company
     */
    public function setType(\Belkarta\CompanyBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Belkarta\CompanyBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Company
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Company
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set percent
     *
     * @param integer $percent
     * @return Company
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get percent
     *
     * @return integer 
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Company
     */
    public function setAddress($address)
    {
        $this->address = $address;

        $geocode = json_decode(file_get_contents('http://geocode-maps.yandex.ru/1.x/?geocode=' . $address . '&format=json'));
        @$this->setCoordinates($geocode->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos);

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set coordinates
     *
     * @param string $coordinates
     * @return Company
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = str_replace(' ', ',', $coordinates);

        return $this;
    }

    /**
     * Get coordinates
     *
     * @return string 
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }
}
