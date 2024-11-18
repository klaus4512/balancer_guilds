import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Show() {
    const { session } = usePage().props;
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Detalhes da Partida
                </h2>
            }
        >
            <Head title={`Partida - ${session.name}`}/>

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h3 className="text-lg font-semibold">Nome da Partida: {session.name}</h3>
                            <h3 className="text-lg font-medium">Jogadores por Guilda: {session.max_guild_players}</h3>
                            <h3 className="text-sm font-light">** O sistema pode colocar um número maior ou menor de jogadores em uma Guilda para garantir que todas tenham um número próximo de jogadores</h3>
                            <hr className="mb-2 border-2"/>
                            {session.guilds
                                .sort((a, b) => a.name.localeCompare(b.name))
                                .map((guild) => (
                                <div key={guild.id} className="mt-4">
                                    <h5 className="text-base font-semibold">{guild.name}</h5>
                                    <h5 className="text-base font-medium">Nivel da Guilda: {guild.average_rating.toFixed(2)}</h5>
                                    {guild.message && (
                                        <h5 className="text-base font-medium"
                                            dangerouslySetInnerHTML={{__html: `Mensagens: `+guild.message.replace(/\n/g, '<br>')}}></h5>
                                    )}
                                    <hr className="mb-2"/>
                                    <ul className="list-disc list-inside">
                                        {guild.players
                                            .sort((a, b) => a.character_class.description.localeCompare(b.character_class.description))
                                            .map((player) => (
                                                <li key={player.id}>{player.name} - {player.character_class.description} - {player.level}</li>
                                            ))}
                                    </ul>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
