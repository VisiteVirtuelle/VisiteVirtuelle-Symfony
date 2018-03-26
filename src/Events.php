<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Vincent Claveau <vinc.claveau@gmail.com>
 * Guillaume Vidal <guillaume.vidal@gmail.com>
 *
 */

namespace App;

/**
 * This class defines the names of all the events dispatched in
 * our project. It's not mandatory to create a
 * class like this, but it's considered a good practice.
 *
 */
final class Events
{
    /**
     * For the event naming conventions, see:
     * https://symfony.com/doc/current/components/event_dispatcher.html#naming-conventions.
     *
     * @Event("Symfony\Component\EventDispatcher\GenericEvent")
     *
     * @var string
     */
    const USER_REGISTERED = 'user.registered';
    const USER_PROFILE_EDIT_SUCCESS = 'user.profile.edit.success';
    const VISIT_EDITOR_EDIT_SUCCESS = 'visit.editor.edit.success';
    const VISIT_EDITOR_NEW_SUCCESS = 'visit.editor.new.success';
}
