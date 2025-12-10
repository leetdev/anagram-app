import { useState } from 'react'
import { fetch as fetchRoute } from '@/routes/word-base'

type Message = {
    type: 'success' | 'error'
    text: string
} | null

export default function WordBaseForm() {
    const initial = {
        name: '',
        url: ''
    }
    const [values, setValues] = useState(initial)
    const [errors, setErrors] = useState(initial)
    const [message, setMessage] = useState<Message>(null)
    const [loading, setLoading] = useState<boolean>(false)

    function handleChange(e) {
        setValues(values => ({
            ...values,
            [e.target.id]: e.target.value
        }))
    }

    function handleSubmit(e) {
        e.preventDefault()

        setLoading(true)
        setErrors(initial)
        setMessage(null)

        fetch(fetchRoute().url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(values)
        })
            .then(response => response.json())
            .then(result => {
                if (result.errors) {
                    setMessage(null)
                    setErrors(result.errors)
                } else {
                    console.log(result)
                    setMessage({
                        type: result.status,
                        text: result.message,
                    })
                    setErrors(initial)
                }
            })
            .finally(() => {
                setLoading(false)
            })
    }

    return (
        <form onSubmit={handleSubmit} className="space-y-4">
            <div>
                <label className="block font-bold">Name</label>
                <input
                    id="name"
                    type="text"
                    className="border p-2 w-full"
                    onChange={handleChange}
                />
                {errors.name && <div className="text-red-600">{errors.name}</div>}
            </div>

            <div>
                <label className="block font-bold">URL</label>
                <input
                    id="url"
                    type="text"
                    className="border p-2 w-full"
                    onChange={handleChange}
                />
                {errors.url && <div className="text-red-600">{errors.url}</div>}
            </div>

            {message && (
                <p
                    className={`mt-4 ${
                        message.type === "error" ? "text-red-600" : "text-green-600"
                    }`}
                >
                    {message.text}
                </p>
            )}

            <button
                disabled={loading}
                className="bg-blue-600 text-white px-4 py-2 rounded"
            >
                {loading ? 'Importing…' : 'Import'}
            </button>

            <a className="ml-3 inline-flex items-center space-x-1 font-medium text-[#f53003] underline underline-offset-4 dark:text-[#FF4433]"
               href="/">
                Back
            </a>
        </form>
    )
}
