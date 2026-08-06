import React from 'react';
import { useForm } from '@inertiajs/react';
import { Card, Form, Input, Select, Button, Switch, Typography, Space, App } from 'antd';
import { ArrowLeftOutlined } from '@ant-design/icons';
import AuthenticatedLayout from '@/Pages/Layouts/AuthenticatedLayout';

const { Title } = Typography;
const { TextArea } = Input;

export default function KBEdit({ article, apps }) {
    const { message: messageApi } = App.useApp();

    const { data, setData, patch, processing, errors } = useForm({
        app_id: article.app_id || null,
        title: article.title,
        content: article.content,
        tags: article.tags || [],
        is_published: article.is_published,
    });

    const handleSubmit = () => {
        patch(`/kb/${article.id}`, {
            onSuccess: () => {
                messageApi.success('Artikel berhasil diperbarui!');
            },
        });
    };

    return (
        <AuthenticatedLayout>
            <Space style={{ marginBottom: 16 }}>
                <Button icon={<ArrowLeftOutlined />} href="/kb">Kembali</Button>
            </Space>

            <Card style={{ maxWidth: 800 }}>
                <Title level={4} style={{ marginBottom: 24 }}>Edit Artikel</Title>

                <Form layout="vertical" onFinish={handleSubmit}>
                    <Form.Item
                        label="Judul Artikel"
                        validateStatus={errors.title ? 'error' : ''}
                        help={errors.title}
                        required
                    >
                        <Input
                            placeholder="Masukkan judul artikel"
                            value={data.title}
                            onChange={e => setData('title', e.target.value)}
                        />
                    </Form.Item>

                    <Form.Item
                        label="Aplikasi"
                        validateStatus={errors.app_id ? 'error' : ''}
                        help={errors.app_id}
                    >
                        <Select
                            placeholder="Pilih aplikasi"
                            allowClear
                            value={data.app_id}
                            onChange={v => setData('app_id', v)}
                            options={apps.map(a => ({ value: a.id, label: a.name }))}
                        />
                    </Form.Item>

                    <Form.Item
                        label="Konten"
                        validateStatus={errors.content ? 'error' : ''}
                        help={errors.content}
                        required
                    >
                        <TextArea
                            rows={12}
                            placeholder="Tulis konten artikel di sini..."
                            value={data.content}
                            onChange={e => setData('content', e.target.value)}
                        />
                    </Form.Item>

                    <Form.Item label="Tag">
                        <Select
                            mode="tags"
                            placeholder="Tambahkan tag"
                            value={data.tags}
                            onChange={v => setData('tags', v)}
                        />
                    </Form.Item>

                    <Form.Item label="Status Publikasi">
                        <Switch
                            checked={data.is_published}
                            onChange={v => setData('is_published', v)}
                            checkedChildren="Dipublikasi"
                            unCheckedChildren="Draf"
                        />
                    </Form.Item>

                    <Form.Item>
                        <Button
                            type="primary"
                            htmlType="submit"
                            loading={processing}
                            size="large"
                        >
                            Simpan Perubahan
                        </Button>
                    </Form.Item>
                </Form>
            </Card>
        </AuthenticatedLayout>
    );
}
