#!/usr/bin/python
#!/usr/bin/python
# coding=utf-8

################################################################
# dummy.py
################################################################

# `C:\Python37\python.exe -m pip install --upgrade pip`
# `C:\Python37\python.exe -m pip install psycopg2`

from configparser import ConfigParser
import psycopg2

################################################################

class DatabaseTest():

    ################################################################

    def __init__(self):
        self.conn = None
        self.cur = None
        self.cmd = ''

    def __del__(self):
        if self.cur is not None:
            self.cur.close()
            self.print_head('Database cursor closed.')
        if self.conn is not None:
            self.conn.close()
            self.print_head('Database connection closed.')

    ################################################################

    @staticmethod
    def load_config(filename = 'database.ini', section = 'postgresql'):
        parser = ConfigParser()
        parser.read(filename)

        db = {}
        if parser.has_section(section):
            params = parser.items(section)
            for param in params:
                db[param[0]] = param[1]
        else:
            raise Exception(f'Section "{section}" not found in file "{filename}"!')

        return db

    ################################################################

    @staticmethod
    def load_table_data(filename = 'table_defs.inc'):
        with open(filename, 'r') as file:
            text = file.read()
            return text.split('\n\n')

    ################################################################

    @staticmethod
    def print_head(msg: str):
        x = '-' * 64
        print('', x, '- ' + msg, x, sep = '\n')

    ################################################################

    def add_translations(self):

        langs = [
            [None, 'pol', 'Polski'],
            [None, 'eng', 'English']
        ]

        texts = [
            ['LANGUAGE', [
                'Język',
                'Language'
            ]],
            ['TITLE_LOGIN', [
                'Logowanie do serwisu',
                'Login to website'
            ]],
            ['TITLE_REGISTER', [
                'Rejestracja użytkownika',
                'User registration'
            ]],
            ['TITLE_BROWSE', [
                'Przeglądanie notatek',
                'Browsing notes'
            ]],
            ['TITLE_SETTINGS', [
                'Ustawienia użytkownika',
                'User settings'
            ]],
            ['TITLE_NOTE', [
                'Twoja notatka',
                'Your note'
            ]]
        ]

        self.print_head('Adding languages and translations')

        for lang in langs:
            print()

            self.cmd = f"""
            INSERT INTO Languages(code, name)
            VALUES ('{lang[1]}', '{lang[2]}')
            RETURNING lang_id
            """
            self.run_command()

            lang[0] = self.cur.fetchone()[0]
            print(lang)

        print()

        for text in texts:
            print()

            self.cmd = f"""
            INSERT INTO Translation_Short(shortname)
            VALUES ('{text[0]}')
            RETURNING text_id
            """
            self.run_command()

            t_id = self.cur.fetchone()[0]

            for i, tra in enumerate(text[1]):

                self.cmd = f"""
                INSERT INTO Translation_Text(text_id, lang_id, text)
                VALUES ({t_id}, {langs[i][0]}, '{tra}')
                """
                self.run_command()

        print()

        self.conn.commit()

        self.cmd = """
        SELECT
          ts.shortname,
          l.code,
          tt.text
        FROM
          Translation_Text AS tt
        INNER JOIN
          Translation_Short AS ts
          USING(text_id)
        INNER JOIN
          Languages as l
          USING(lang_id)
        """
        self.run_command()

        for row in self.cur.fetchall():
            for col in row:
                print(f'[ {col:16s} ]', end = '')
            print()

        print()

    ################################################################

    def prepare_database(self):

        try:
            self.connection_test()
            self.create_tables()
            self.add_translations()

        except (Exception, psycopg2.DatabaseError) as error:
            self.print_head('Wystąpił Wyjątek:')
            print(error)

    ################################################################

    def connection_test(self):
        """Connect to the PostgreSQL database server"""

        conn_params = self.load_config()

        self.print_head('Connecting to the PostgreSQL database...')
        self.conn = psycopg2.connect(**conn_params)
        self.cur = self.conn.cursor()

        print('PostgreSQL database version:')
        self.cur.execute('SELECT version()')
        db_version = self.cur.fetchone()
        print(db_version)

    ################################################################

    def run_command(self, print_full: bool = True):

        cmd = ' '.join([l.strip() for l in self.cmd.split('\n')])

        if print_full:
            print(f' > {cmd}')
        else:
            part = cmd.split('(')[0]
            print(f' > {part}(...)')

        self.cur.execute(cmd)

    ################################################################

    def create_tables(self):
        """Remove existing tables and create new tables"""

        self.print_head('Resetting database tables...')

        tables = self.load_table_data()
        for i, tab in enumerate(tables):
            if 0 != i:
                table_name = tab.split(' ')[0]
                print()

                self.cmd = f'DROP TABLE IF EXISTS {table_name}'
                self.run_command()

                self.cmd = f'CREATE TABLE {tab}'
                self.run_command(False)

                self.cmd = f'SELECT * FROM {table_name} LIMIT 0'
                self.run_command()

                colnames = [desc[0] for desc in self.cur.description]
                for col in colnames:
                    print(f'[ {col} ]', end = '')

                print()

        print()

        self.conn.commit()

    ################################################################

################################################################

if '__main__' == __name__:
    db = DatabaseTest()
    db.prepare_database()

################################################################
