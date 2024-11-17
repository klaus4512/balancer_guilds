import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, Link } from '@inertiajs/react';
import TextInput from '@/Components/TextInput';
import ButtonLink from "@/Components/ButtonLink.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";

export default function CreateSession({ players = [] }) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        maxGuildPlayers: '',
        players: [],
    });

    const handleCheckboxChange = (playerId) => {
        const newPlayers = data.players.includes(playerId)
            ? data.players.filter(id => id !== playerId)
            : [...data.players, playerId];
        setData('players', newPlayers);
    };

    const submit = (e) => {
        e.preventDefault();
        post(route('session.store'));
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Criar uma nova partida
                </h2>
            }
        >
            <Head title="Criar Player" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <form onSubmit={submit}>
                                <div>
                                    <label htmlFor="name">Nome</label>
                                    <TextInput
                                        id="name"
                                        type="text"
                                        value={data.name}
                                        onChange={(e) => setData('name', e.target.value)}
                                        className="mt-1 block w-full"
                                    />
                                    {errors.name && <div className="text-red-600">{errors.name}</div>}
                                </div>
                                <div className="mt-4">
                                    <label htmlFor="maxGuildPlayers">Número de jogadores por guilda</label>
                                    <TextInput
                                        id="maxGuildPlayers"
                                        type="number"
                                        value={data.maxGuildPlayers}
                                        onChange={(e) => setData('maxGuildPlayers', e.target.value)}
                                        className="mt-1 block w-full"
                                    />
                                    {errors.maxGuildPlayers && <div className="text-red-600">{errors.maxGuildPlayers}</div>}
                                </div>
                                <div className="mt-4">
                                    <label>Jogadores</label>
                                    <div className="mt-2 space-y-2">
                                        {players.map(player => (
                                            <div key={player.id} className="flex items-center">
                                                <input
                                                    id={`player-${player.id}`}
                                                    type="checkbox"
                                                    value={player.id}
                                                    checked={data.players.includes(player.id)}
                                                    onChange={() => handleCheckboxChange(player.id)}
                                                    className="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                />
                                                <label htmlFor={`player-${player.id}`} className="ml-2 block text-sm text-gray-900">
                                                    {player.name} - {player.character_class.description} - Nível: {player.level}
                                                </label>
                                            </div>
                                        ))}
                                    </div>
                                    {errors.players && <div className="text-red-600">{errors.players}</div>}
                                </div>
                                <div className="mt-4">
                                    <PrimaryButton type="submit" className="mr-4" disabled={processing}>
                                        Criar
                                    </PrimaryButton>
                                    <ButtonLink href={route('player.index')}> Cancelar </ButtonLink>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
