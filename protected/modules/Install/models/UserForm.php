<?php


class UserForm extends CFormModel {
    public $username;
    public $password;
    public $email;
    
    const ROLE_USER=0;
	const ROLE_ADMIN=1;

    
    public function rules() {
        return array(
            array('username, password', 'required'),
        );
    }

    /**
     * Returns the attribute labels.
     * Attribute labels are mainly used in error messages of validation.
     * By default an attribute label is generated using {@link generateAttributeLabel}.
     * This method allows you to explicitly specify attribute labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to
     * merge the parent labels with child labels using functions like array_merge().
     *
     * @return array attribute labels (name=>label)
     * @see generateAttributeLabel
     */
    public function attributeLabels() {
        return array(
			'username'=>'Username',
            'password'=>'Password',
        	'email'=>'Email',
        );
    }
}
