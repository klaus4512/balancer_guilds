import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';
import ButtonLink from "@/Components/ButtonLink.jsx";
import Pagination from "@/Components/Pagination.jsx";
import DeleteButton from "@/Components/Player/DeleteButton.jsx";

export default function Index() {
    const { players = []} = usePage().props;
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Jogadores
                </h2>
            }
        >
            <Head title="Jogadores" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <ButtonLink href={route('player.create')}>Cadastrar jogador</ButtonLink>
                        </div>
                        <div className="p-6">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead>
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Classe</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nível</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                {players.data.map((player) => (
                                    <tr key={player.id}>
                                        <td className="px-6 py-4 whitespace-nowrap">{player.name}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{player.character_class.description}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{player.level}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <DeleteButton playerId={player.id}/>
                                        </td>
                                    </tr>
                                ))}
                                </tbody>
                            </table>
                            <div className="mt-4">
                            <Pagination pagination={players} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
