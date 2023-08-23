<?php
namespace App\Bots\valeri_beautybar_bot\Commands;

use Romanlazko\Telegram\App\Commands\CommandsList as DefaultCommandsList;

class CommandsList extends DefaultCommandsList
{
    static protected $commands = [
        'admin'     => [
            AdminCommands\StartCommand::class,
            AdminCommands\MenuCommand::class,
            AdminCommands\HelpCommand::class,
        ],
        'user'      => [
            UserCommands\StartCommand::class,
            UserCommands\MenuCommand::class,
            UserCommands\About::class,

            // Appointment
            UserCommands\Appointment\AppointmentCommand::class,
            UserCommands\Appointment\CreateProfile::class,
            UserCommands\Appointment\FirstName::class,
            UserCommands\Appointment\LastName::class,
            UserCommands\Appointment\Phone::class,
            UserCommands\Appointment\AwaitFirstName::class,
            UserCommands\Appointment\AwaitLastName::class,
            UserCommands\Appointment\AwaitPhone::class,
            UserCommands\Appointment\SaveProfile::class,
            UserCommands\Appointment\ChooseMaster::class,
            UserCommands\Appointment\SaveMaster::class,
            UserCommands\Appointment\ChooseWeek::class,
            UserCommands\Appointment\ChooseDay::class,
            UserCommands\Appointment\ChooseTerm::class,
            UserCommands\Appointment\ConfirmAppointCommand::class,
            UserCommands\Appointment\Appoint::class,

            UserCommands\MyAppointments::class,
            UserCommands\ShowMyAppointment::class,
            UserCommands\CancelAppointmentCommand::class,
            UserCommands\CancelCommand::class,
            UserCommands\DefaultCommand::class,

            UserCommands\HelpCommand::class,
            UserCommands\CustomReferalCommand::class,
        ],
        'supergroup' => [
            DefaultCommands\EmptyResponseCommand::class,
        ],
        'default'   => [
            DefaultCommands\DefaultCommand::class,
            DefaultCommands\SendResultCommand::class,
            DefaultCommands\EmptyResponseCommand::class,
        ]
        
    ];

    static public function getCommandsList(?string $auth)
    {
        return array_merge(
            (self::$commands[$auth] ?? []), 
            (self::$default_commands[$auth] ?? [])
        ) 
        ?? self::getCommandsList('default');
    }

    static public function getAllCommandsList()
    {
        foreach (self::$commands as $auth => $commands) {
            $commands_list[$auth] = self::getCommandsList($auth);
        }
        return $commands_list;
    }
}
