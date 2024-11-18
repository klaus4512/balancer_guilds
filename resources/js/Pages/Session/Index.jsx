import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, usePage} from '@inertiajs/react';
import ButtonLink from "@/Components/ButtonLink.jsx";
import Pagination from "@/Components/Pagination.jsx";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faEye } from '@fortawesome/free-solid-svg-icons';
export default function Index() {
    const { sessions = []} = usePage().props;
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Partidas
                </h2>
            }
        >
            <Head title="Jogadores" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <ButtonLink href={route('session.create')}>Criar uma nova partida</ButtonLink>
                        </div>
                        <div className="p-6">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead>
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                {sessions.data.map((session) => (
                                    <tr key={session.id}>
                                        <td className="px-6 py-4 whitespace-nowrap">{session.name}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <Link
                                                href={route('session.show', session.id)}
                                                className="inline-flex items-center px-4 py-2 bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                            >
                                                <FontAwesomeIcon icon={faEye}/>
                                            </Link>
                                        </td>
                                    </tr>
                                ))}
                                </tbody>
                            </table>
                            <div className="mt-4">
                                <Pagination pagination={sessions}/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
