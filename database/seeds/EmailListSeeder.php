<?php

use Illuminate\Database\Seeder;
use Spatie\Mailcoach\Models\EmailList;
use Spatie\Mailcoach\Models\Subscriber;

class EmailListSeeder extends Seeder
{
    public function run()
    {

        factory(EmailList::class, 1)
            ->create()
            ->each(function (EmailList $emailList) {
                foreach (range(1, faker()->numberBetween(1, 500)) as $i) {
                    $email = faker()->email;
                    $emailList->subscribeSkippingConfirmation($email);

                    if (faker()->boolean(5)) {
                        $emailList->unsubscribe($email);
                    }
                }
            });


        $emailList = EmailList::create([
            'name' => 'my audience',
            'default_from_email' => 'freek@spatie.be',
            'default_from_name' => 'Freek Van der Herten',
        ]);

        foreach (range(1, 10) as $i) {
            Subscriber::createWithEmail("freek+test{$i}@spatie.be")->subscribeTo($emailList);
        }

        Subscriber::first()->update(['subscribed_at' => null]);
    }
}
