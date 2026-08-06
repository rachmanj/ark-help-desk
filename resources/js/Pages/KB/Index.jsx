import React, { useState } from 'react';
import { usePage, router } from '@inertiajs/react';
import { Table, Tag, Input, Select, Space, Button, Typography, Card, Row, Col } from 'antd';
import { PlusOutlined, SearchOutlined, ReloadOutlined, EyeOutlined } from '@ant-design/icons';
import AuthenticatedLayout from '@/Pages/Layouts/AuthenticatedLayout';

const { Title } = Typography;

export default function KBIndex({ articles, filters, apps }) {
    const [search, setSearch] = useState(filters.search || '');

    const handleSearch = () => {
        router.get('/kb', { ...filters, search, page: 1 }, { preserveState: true, replace: true });
    };

    const handleFilter = (key, value) => {
        router.get('/kb', { ...filters, [key]: value, page: 1 }, { preserveState: true, replace: true });
    };

    const handleReset = () => {
        setSearch('');
        router.get('/kb', {}, { preserveState: true, replace: true });
    };

    const columns = [
        {
            title: 'Judul',
            dataIndex: 'title',
            ellipsis: true,
            render: (text, record) => (
                <Space>
                    <span>{text}</span>
                </Space>
            ),
        },
        {
            title: 'Aplikasi',
            dataIndex: ['app', 'name'],
            width: 150,
        },
        {
            title: 'Status',
            dataIndex: 'is_published',
            width: 100,
            render: (published) => (
                <Tag color={published ? 'green' : 'default'}>
                    {published ? 'Dipublikasi' : 'Draf'}
                </Tag>
            ),
        },
        {
            title: 'Dilihat',
            dataIndex: 'view_count',
            width: 80,
        },
        {
            title: 'Bermanfaat',
            dataIndex: 'helpful_count',
            width: 100,
        },
        {
            title: 'Terakhir Diperbarui',
            dataIndex: 'updated_at',
            width: 170,
            render: (date) => new Date(date).toLocaleString('id-ID'),
        },
        {
            title: 'Aksi',
            width: 100,
            render: (_, record) => (
                <Button
                    type="link"
                    icon={<EyeOutlined />}
                    href={`/kb/${record.id}/edit`}
                >
                    Edit
                </Button>
            ),
        },
    ];

    return (
        <AuthenticatedLayout>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <Title level={3} style={{ margin: 0 }}>Basis Pengetahuan</Title>
                <Button type="primary" icon={<PlusOutlined />} href="/kb/create">
                    Artikel Baru
                </Button>
            </div>

            <Card style={{ marginBottom: 16 }} bodyStyle={{ padding: 16 }}>
                <Row gutter={[12, 12]} align="middle">
                    <Col xs={24} sm={12} md={12}>
                        <Input
                            placeholder="Cari artikel (FULLTEXT)..."
                            prefix={<SearchOutlined />}
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            onPressEnter={handleSearch}
                        />
                    </Col>
                    <Col xs={12} sm={6} md={4}>
                        <Select
                            placeholder="Aplikasi"
                            allowClear
                            style={{ width: '100%' }}
                            value={filters.app_id || undefined}
                            onChange={v => handleFilter('app_id', v)}
                            options={apps.map(a => ({ value: a.id, label: a.name }))}
                        />
                    </Col>
                    <Col xs={12} sm={6} md={4}>
                        <Space>
                            <Button onClick={handleSearch} type="primary">Cari</Button>
                            <Button onClick={handleReset} icon={<ReloadOutlined />}>Reset</Button>
                        </Space>
                    </Col>
                </Row>
            </Card>

            <Table
                columns={columns}
                dataSource={articles.data}
                rowKey="id"
                pagination={{
                    current: articles.current_page,
                    total: articles.total,
                    pageSize: articles.per_page,
                    showSizeChanger: false,
                    onChange: (page) => router.get('/kb', { ...filters, page }, { preserveState: true, replace: true }),
                }}
                size="middle"
            />
        </AuthenticatedLayout>
    );
}
