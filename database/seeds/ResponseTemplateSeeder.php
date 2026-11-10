<?php

use App\Models\ResponseTemplate;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ResponseTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ResponseTemplate::insert([
            ['title' => 'Annonce refusée - problème de contenus',
                'content' => 'Bonjour ,
Les annonces déposées sur le site terredeliens.org font l’objet d’une modération.
Votre annonce a été refusée car elle ne correspond pas aux critères de publication définis et explicités dans la charte d’utilisation de la plateforme d’annonces du site.
Vous pouvez modifier et nous soumettre de nouveau votre annonce ou la supprimer. Pour cela, identifiez-vous sur le site.
A bientôt sur Objectif Terres !
',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            ['title' => 'Annonce refusée - problème de forme',
                'content' => "
			Bonjour ,
Les annonces déposées sur le site terredeliens.org font l’objet d’une modération.
Votre annonce a été refusée car elle ne correspond pas aux critères formels de publication définis et explicités dans la charte d’utilisation de la plateforme d'annonces du site.
Vous pouvez modifier et nous soumettre de nouveau votre annonce ou la supprimer. Pour cela, identifiez-vous sur le site.
Cordialement,
L’équipe de Terre de Liens
			",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            ['title' => 'Annonce refusée - manque de précision',
                'content' => "
			Bonjour ,
Les annonces déposées sur le site terredeliens.org font l’objet d’une modération.
Nous ne pouvons la valider en l’état parce que son objectif n’apparaît pas clairement. Nous vous invitons à la reformuler et à la préciser afin de lever toute ambiguïté. Elle gagnera en efficacité.
Pour mémoire, nous vous rappelons que la modération des annonces est soumise à des critères de publication définis et explicités dans la charte d’utilisation de la plateforme d'annonces du site.
Vous pouvez modifier et nous soumettre de nouveau votre annonce ou la supprimer. Pour cela, identifiez-vous sur le site.
Cordialement,
L’équipe de Terre de Liens

			",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            ['title' => 'Annonce refusée - problème d\'opinion',
                'content' => "
			Bonjour ,
Les annonces déposées sur le site terredeliens.org font l’objet d’une modération.
Nous ne pouvons la valider en l’état car votre annonce n’est pas assez factuelle. La plateforme d’annonces du site web de Terre de Liens n’est pas un forum ou une tribune pour exposer ses opinions mais un outil d’interaction pragmatique entre internautes. Nous vous invitons à reformuler votre projet et à demander de nouveau la publication.
Vous pouvez modifier et nous soumettre de nouveau votre annonce ou la supprimer. Pour cela, identifiez-vous sur le site.
Pour mémoire, nous vous rappelons que la modération des annonces est soumise à des critères de publication définis et explicités dans la charte d’utilisation de la plateforme d'annonces du site.
Cordialement,
L’équipe de Terre de Liens
			",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]]);
    }
}
