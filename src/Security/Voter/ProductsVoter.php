<?php

namespace App\Security\Voter;

use App\Entity\Products;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
// use \Symfony\Bundle\SecurityBundle\Security

class ProductsVoter extends Voter {

    const EDIT = 'PRODUCT_EDIT';
    const DELETE = 'PRODUCT_DELETE';

    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    protected function supports(string $attribute, $product):bool{
        if(!in_array($attribute,[self::EDIT, self::DELETE])){
            return false;
        }
        if(!$product instanceOf Products){
            return false;
        }
        return true;

        // Autre façon d'écrire tout ça :
        // return in_array($attribute,[self::EDIT, self::DELETE]) && $product instanceOf Products
    }

    protected function voteOnAttribute($attribute, $product, TokenInterface $token):bool{
        // Récupération de l'utilisateur à partir du token
        $user = $token->getUser();

        // Si l'utilisateur n'est pas connecté, on retourne false
        if(!$user instanceof UserInterface){
            return false;
        }

        // Vérification que l'utilisateur est admin-> on valide  
        if($this->security->isGranted('ROLE_ADMIN')){
            return true;
        }

        // si l'utilisateur n'est pas admin , on vérife ses permissions , en fonction des différents actions possible
        switch($attribute){
            case self::EDIT:
                // Edition
                return $this->canEdit();
                break;
            case self::DELETE:
                // Suppression
                return $this->canDelete();
                break;
        }

    }
// Vérification que l'utilisateur a le role "product_admin":
    private function canEdit(){
        return $this->security->isGranted('ROLE_PRODUCT_ADMIN');
    }
    private function canDelete(){
        return $this->security->isGranted('ROLE_PRODUCT_ADMIN');
    }

}
