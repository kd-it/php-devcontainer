import os
import unittest
from selenium import webdriver
import logging

# ロギング出力を制御するフラグ（True: 出力する, False: 出力しない）
ENABLE_LOGGING = True

# ロギングの設定をクラスの外で一度だけ行う
logger = logging.getLogger(__name__)
# フラグに基づいてロギングレベルを設定
if ENABLE_LOGGING:
    logging.basicConfig(level=logging.INFO)
else:
    logging.basicConfig(level=logging.ERROR)  # INFOレベルのログを抑制

class TestWebConnect(unittest.TestCase):
    # テスト用のサーバー(Selenium grid)
    REMOTE_URL = "http://selenium:4444/wd/hub"

    # テストファイル名
    TEST_FILE = "public/.gitkeep.html"
    TEST_PHP_FILE = "public/.gitkeep.php"

    # publicディレクトリを作ったかどうかのフラグ
    PUBLIC_DIR_CREATED = False

    @classmethod
    def setUpClass(cls):
        logger.info("Selenuimに接続します")
        cls.driver = webdriver.Remote(cls.REMOTE_URL, options=webdriver.ChromeOptions())
        logger.info("Selenuimに接続しました")
        cls.driver.implicitly_wait(10)

    def setUp(self):
        # publicディレクトリがない場合は作成する
        if not os.path.isdir("public"):
            os.mkdir("public")
            self.PUBLIC_DIR_CREATED = True
            logger.info("Create public directory")
        # ファイル public/.gitkeep.html を作成する。中身は"Hello, Keeper"とする
        with open(self.TEST_FILE, "w") as f:
            f.write("<html><body>Hello, Keeper</body></html>")
            logger.info("Create test file")
        with open(self.TEST_PHP_FILE, "w") as f:
            f.write("<html><body><?php echo 'Hello, PHP'; ?></body></html>")
            logger.info("Create test php file")

    def test_web_connect(self):
        # http://web/.gitkeepにアクセス、このときに得られるData形式はApplication/Octet-streamであることを確認
        filename = os.path.basename(self.TEST_FILE)
        self.driver.get(f'http://web/{filename}')
        logger.info(self.driver.page_source)
        self.assertIn("Hello, Keeper", self.driver.page_source)

    def test_php_connect(self):
        # http://web/.gitkeepにアクセス、このときに得られるData形式はApplication/Octet-streamであることを確認
        filename = os.path.basename(self.TEST_PHP_FILE)
        self.driver.get(f'http://web/{filename}')
        logger.info(self.driver.page_source)
        self.assertIn("Hello, PHP", self.driver.page_source)

    def tearDown(self):
        # public/.gitkeep.htmlを削除
        os.remove(self.TEST_FILE)
        os.remove(self.TEST_PHP_FILE)
        # publicディレクトリを作成した場合は削除する
        if self.PUBLIC_DIR_CREATED:
            os.rmdir("public")
            logger.info("Remove public directory")

    @classmethod
    def tearDownClass(cls):
        cls.driver.quit()
        logger.info("Seleniumとの接続を終了しました")

if __name__ == '__main__':
    unittest.main()
