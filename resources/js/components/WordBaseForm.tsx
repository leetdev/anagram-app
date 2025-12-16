import { postApi } from '@/lib/utils';
import { fetch as fetchRoute } from '@/routes/word-base';
import { WordBase } from '@/types';
import { useState } from 'react';

type Message = {
    type: 'success' | 'error';
    text: string;
} | null;

export default function WordBaseForm() {
    const initial: WordBase = {
        name: '',
        url: '',
    };
    const [values, setValues] = useState<WordBase>(initial);
    const [errors, setErrors] = useState<WordBase>(initial);
    const [message, setMessage] = useState<Message>(null);
    const [loading, setLoading] = useState<boolean>(false);

    const handleChange = (e) => {
        setValues((values) => ({
            ...values,
            [e.target.id]: e.target.value,
        }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        setLoading(true);
        setErrors(initial);
        setMessage(null);

        postApi(fetchRoute().url, values)
            .then((result) => {
                if (result.errors) {
                    setMessage(null);
                    setErrors(result.errors);
                } else {
                    setMessage({
                        type: result.status,
                        text: result.message,
                    });
                    setErrors(initial);
                }
            })
            .finally(() => {
                setLoading(false);
            });
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-4">
            <div>
                <label className="block font-bold">Name</label>
                <input id="name" type="text" className="w-full border p-2" onChange={handleChange} />
                {errors.name && <div className="text-red-600">{errors.name}</div>}
            </div>

            <div>
                <label className="block font-bold">URL</label>
                <input id="url" type="text" className="w-full border p-2" onChange={handleChange} />
                {errors.url && <div className="text-red-600">{errors.url}</div>}
            </div>

            {message && <p className={`mt-4 ${message.type === 'error' ? 'text-red-600' : 'text-green-600'}`}>{message.text}</p>}

            <button disabled={loading} className="rounded bg-blue-600 px-4 py-2 text-white">
                {loading ? 'Importing…' : 'Import'}
            </button>

            <a
                className="ml-3 inline-flex items-center space-x-1 font-medium text-[#f53003] underline underline-offset-4 dark:text-[#FF4433]"
                href="/"
            >
                Back
            </a>
        </form>
    );
}
